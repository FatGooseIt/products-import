<?php

declare(strict_types=1);

namespace App\Controller;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/', name: 'homepage')]
class IndexAction
{
    public function __invoke(): Response
    {
        return new RedirectResponse('/api/doc');
    }
}
