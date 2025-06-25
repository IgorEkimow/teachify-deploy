<?php

namespace App\Controller\Web\Group\Update\UpdateName\v1;

use App\Controller\Web\Group\Update\UpdateName\v1\Input\UpdateNameGroupDTO;
use App\Domain\Entity\Group;
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

    #[Route(path: 'api/v1/group/{id}', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function __invoke(#[MapEntity(id: 'id')] Group $group, #[MapQueryString] UpdateNameGroupDTO $updateNameGroupDTO): Response
    {
        $this->manager->updateName($group, $updateNameGroupDTO);

        return new JsonResponse(['success' => true]);
    }
}