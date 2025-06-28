<?php

namespace App\Controller\Web\Teacher\Update\UpdateLogin\v1;

use App\Controller\Web\Teacher\Update\UpdateLogin\v1\Input\UpdateLoginTeacherDTO;
use App\Domain\Entity\Teacher;
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

    #[Route(path: 'api/v1/teacher/{id}', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function __invoke(#[MapEntity(id: 'id')] Teacher $teacher, #[MapQueryString] UpdateLoginTeacherDTO $updateLoginTeacherDTO): Response
    {
        $this->manager->updateLogin($teacher, $updateLoginTeacherDTO);

        return new JsonResponse(['success' => true]);
    }
}