<?php

namespace App\Controller\Web\Student\Delete\v1;

use App\Domain\Entity\Student;
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

    #[Route(path: 'api/v1/student/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'id')] Student $student): Response
    {
        $this->manager->deleteStudent($student);

        return new JsonResponse(['success' => true]);
    }
}