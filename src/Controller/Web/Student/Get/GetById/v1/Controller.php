<?php

namespace App\Controller\Web\Student\Get\GetById\v1;

use App\Controller\Web\Student\Get\GetById\v1\Input\GetStudentDTO;
use App\Controller\Web\Student\Get\GetById\v1\Output\GotStudentDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/student', methods: ['GET'])]
    public function __invoke(#[MapQueryString] GetStudentDTO $getStudentDTO): GotStudentDTO
    {
        return $this->manager->getStudentById($getStudentDTO);
    }
}