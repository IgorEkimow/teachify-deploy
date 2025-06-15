<?php

namespace App\Controller\Web\CreateStudent\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager) {
    }

    #[Route(path: 'api/v1/user', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $name = $request->request->get('name');
        $login = $request->request->get('login');
        $skills = $request->request->all('skills');

        // Если отправляю JSON
        // $data = json_decode($request->getContent(), true);
        // $name = $data['name'] ?? null;
        // $login = $data['login'] ?? null;
        // $skills = $data['skills'] ?? [];

        $user = $this->manager->create($name, $login, $skills);
        if ($user === null) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($user->toArray());
    }
}