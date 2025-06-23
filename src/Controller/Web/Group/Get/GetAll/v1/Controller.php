<?php

namespace App\Controller\Web\Group\Get\GetAll\v1;

use App\Domain\Entity\Group;
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

    #[Route(path: 'api/v1/groups', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        return new JsonResponse(array_map(static fn (Group $groups): array => $groups->toArray(), $this->manager->getAll()));
    }
}