<?php

namespace App\Controller\Web\Teacher\Get\GetById\v1;

use App\Domain\Entity\Teacher;
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

    #[Route(path: 'api/v1/teacher', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $teacherId = $request->query->get('id');
        $teacher = $this->manager->getTeacherById($teacherId);

        if ($teacher instanceof Teacher) {
            return new JsonResponse($teacher->toArray());
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}