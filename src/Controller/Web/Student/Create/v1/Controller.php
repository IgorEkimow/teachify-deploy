<?php

namespace App\Controller\Web\Student\Create\v1;

use App\Controller\Web\Student\Create\v1\Input\CreateStudentDTO;
use App\Controller\Web\Student\Create\v1\Output\CreatedStudentDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/student', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateStudentDTO $createStudentDTO): CreatedStudentDTO
    {
        return $this->manager->create($createStudentDTO);
    }
}