<?php

namespace App\Controller\Web\Student\Create\v1;

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

    #[Route(path: 'api/v1/student', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $name = $request->request->get('name');
        $login = $request->request->get('login');
        $skills = $request->request->all('skills');

        $user = $this->manager->create($name, $login, $skills) ?? null;

        if ($user === null) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($user->toArray());
    }
}