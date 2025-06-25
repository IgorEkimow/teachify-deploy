<?php

namespace App\Controller\Web\Group\Delete\v1;

use App\Domain\Entity\Group;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/group/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'id')] Group $group): Response
    {
        $this->manager->delete($group);

        return new JsonResponse(['success' => true]);
    }
}