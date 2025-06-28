<?php

namespace App\Controller\Web\Teacher\Get\GetById\v1;

use App\Controller\Web\Teacher\Get\GetById\v1\Input\GetTeacherDTO;
use App\Controller\Web\Teacher\Get\GetById\v1\Output\GotTeacherDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/teacher', methods: ['GET'])]
    public function __invoke(#[MapQueryString] GetTeacherDTO $getTeacherDTO): GotTeacherDTO
    {
        return $this->manager->getTeacherById($getTeacherDTO);
    }
}