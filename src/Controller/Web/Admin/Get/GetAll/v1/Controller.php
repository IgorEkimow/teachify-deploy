<?php

namespace App\Controller\Web\Admin\Get\GetAll\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/admins', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        return new JsonResponse($this->manager->getAll());
    }
}