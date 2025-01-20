<?php

declare(strict_types=1);

namespace App\Action;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/', name: 'homepage')]
final class IndexAction
{
    public function __invoke(): Response
    {
        return new RedirectResponse('/api/doc');
    }
}
