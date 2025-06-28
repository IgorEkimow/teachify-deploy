<?php

namespace App\Controller\Web\Student\Update\UpdateLogin\v1;

use App\Controller\Web\Student\Update\UpdateLogin\v1\Input\UpdateLoginStudentDTO;
use App\Domain\Entity\Student;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/student/{id}', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function __invoke(#[MapEntity(id: 'id')] Student $student, #[MapQueryString] UpdateLoginStudentDTO $updateLoginStudentDTO): Response
    {
        $this->manager->updateLogin($student, $updateLoginStudentDTO);

        return new JsonResponse(['success' => true]);
    }
}