<?php

namespace App\Controller\Web\Group\Get\GetById\v1;

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

    #[Route(path: 'api/v1/group', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $groupId = $request->query->get('id');
        $group = $this->manager->getGroupById($groupId);

        if ($group instanceof Group) {
            return new JsonResponse($group->toArray());
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}