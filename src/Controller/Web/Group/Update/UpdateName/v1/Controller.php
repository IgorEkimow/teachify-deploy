<?php

namespace App\Controller\Web\Group\Update\UpdateName\v1;

use App\Domain\Entity\Group;
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

    #[Route(path: 'api/v1/group/{id}', methods: ['PATCH'])]
    public function __invoke(#[MapEntity(id: 'id')] Group $group, Request $request): Response
    {
        $name = $request->query->get('name');
        $this->manager->updateName($group, $name);

        return new JsonResponse(['success' => true]);
    }
}