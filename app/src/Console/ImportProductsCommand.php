<?php

declare(strict_types=1);

namespace App\Console;

use App\Infrastructure\ImportProduct\ArrayToDtoAdapter\ArrayToProduct\ProductAdapter;
use App\Infrastructure\ImportProduct\DataBaseImport\ProductDataBaseImportBuilder;
use App\Infrastructure\ImportProduct\ReportCreator\ReportCreator;
use App\Infrastructure\ImportProduct\Validator\ProductValidator;
use App\Infrastructure\Service\DataBaseImport\DataBaseImportInterface;
use App\Infrastructure\Service\FileReader\FileTypes\Csv\CsvReaderFactory;
use App\Infrastructure\Service\ImportReporter\ReportBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:products:import', description: 'Import products from a CSV file.')]
final class ImportProductsCommand extends Command
{
    private const string CSV_FILE_PATH = 'public/importFiles/stock.csv';

    private const string TEST_MODE = 'test';

    private array $failedItems = [];

    private int $read = 0;

    private int $inserted = 0;

    private int $skipped = 0;

    public function __construct(
        private readonly ProductAdapter $productMapper,
        private readonly DataBaseImportInterface $import,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            name: 'mode',
            mode: InputArgument::OPTIONAL,
            description: 'Run the import in "test" mode.',
            default: '',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $factory = new CsvReaderFactory();
        $fileIterator = $factory->createFileIterator(self::CSV_FILE_PATH);
        $generator = $factory->createFileReader($fileIterator)->read();

        foreach ($generator as $batch) {
            foreach ($batch as $item) {
                $this->read++;

                try {
                    $productDto = $this->productMapper->adapt($item);

                    $validator = new ProductValidator();
                    $validator->validate($productDto);

                    if ($input->getArgument('mode') !== self::TEST_MODE) {
                        $this->inserted += $this->import->insert(
                            importBuilder: new ProductDataBaseImportBuilder(),
                            importDto: $productDto
                        );
                    }
                } catch (\Exception $e) {
                    $this->failedItems[] = json_encode($item);
                    $this->skipped++;
                }
            }
        }

        $output->writeln($this->getReport());

        return Command::SUCCESS;
    }

    private function getReport(): string
    {
        $reportBuilder = new ReportBuilder();
        $importProductReport = new ReportCreator();
        $importProductReport->setBuilder($reportBuilder);

        $report = $importProductReport->createProductReport(
            failedItems: $this->failedItems,
            read: $this->read,
            inserted: $this->inserted,
            skipped: $this->skipped,
        );

        return $report->getReport();
    }
}
