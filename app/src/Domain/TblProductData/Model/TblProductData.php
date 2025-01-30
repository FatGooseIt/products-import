<?php

namespace App\Domain\TblProductData\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: self::TABLE_NAME)]
class TblProductData
{
    public const string TABLE_NAME = 'tblProductData';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'intProductDataId', length: 10, options: ['unsigned' => true])]
    private int $intProductDataId;

    #[ORM\Column(name: 'strProductName', length: 50)]
    private string $strProductName;

    #[ORM\Column(name: 'strProductDesc', length: 255)]
    private string $strProductDesc;

    #[ORM\Column(name: 'strProductCode', length: 10, unique: true)]
    private string $strProductCode;

    #[ORM\Column(name: 'dtmAdded', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dtmAdded;

    #[ORM\Column(name: 'dtmDiscontinued', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dtmDiscontinued;

    #[ORM\Column(name: 'stmTimestamp', options: ['default' => 'CURRENT_TIMESTAMP', 'onUpdate' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $stmTimestamp;

    #[ORM\Column(type: 'integer')]
    private int $stock;

    #[ORM\Column(name: 'costGbp', type: 'float')]
    private float $costGbp;
}
