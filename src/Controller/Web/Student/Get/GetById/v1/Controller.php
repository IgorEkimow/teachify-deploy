<?php

namespace App\Controller\Web\Student\Get\GetById\v1;

use App\Domain\Entity\Student;
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

    #[Route(path: 'api/v1/student', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $studentId = $request->query->get('id');
        $student = $this->manager->getStudentById($studentId);

        if ($student instanceof Student) {
            return new JsonResponse($student->toArray());
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}