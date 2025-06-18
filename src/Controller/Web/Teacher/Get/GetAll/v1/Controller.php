<?php

namespace App\Controller\Web\Teacher\Get\GetAll\v1;

use App\Domain\Entity\Teacher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager) {
    }

    #[Route(path: 'api/v1/teachers', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        return new JsonResponse(array_map(static fn (Teacher $teacher): array => $teacher->toArray(), $this->manager->getAllTeachers()));
    }
}