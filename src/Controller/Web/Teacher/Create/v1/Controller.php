<?php

namespace App\Controller\Web\Teacher\Create\v1;

use App\Controller\Web\Teacher\Create\v1\Input\CreateTeacherDTO;
use App\Controller\Web\Teacher\Create\v1\Output\CreatedTeacherDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
readonly class Controller
{
    public function __construct(private Manager $manager)
    {
    }

    #[Route(path: 'api/v1/teacher', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateTeacherDTO $createTeacherDTO): CreatedTeacherDTO
    {
        return $this->manager->create($createTeacherDTO);
    }
}