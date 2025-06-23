<?php

namespace App\Controller\Web\Teacher\Delete\v1;

use App\Domain\Entity\Teacher;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(path: 'api/v1/teacher/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'id')] Teacher $teacher): Response
    {
        $this->manager->deleteTeacher($teacher);

        return new JsonResponse(['success' => true]);
    }
}