<?php

namespace App\Controller\Web\Teacher\Update\UpdateLogin\v1;

use App\Domain\Entity\Teacher;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager)
    {
    }

    #[Route(path: 'api/v1/teacher/{id}', methods: ['PATCH'])]
    public function __invoke(#[MapEntity(id: 'id')] Teacher $teacher, Request $request): Response
    {
        $login = $request->query->get('login');
        $this->manager->updateLogin($teacher, $login);

        return new JsonResponse(['success' => true]);
    }
}