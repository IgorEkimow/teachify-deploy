<?php

namespace App\Controller\Web\CreateStudent\v1;

use App\Domain\Entity\Student;
use App\Domain\Service\StudentBuilderService;

class Manager
{
    public function __construct(private readonly StudentBuilderService $studentBuilderService)
    {
    }

    public function create(string $name, string $login, array $skills): ?Student
    {
        return $this->studentBuilderService->createStudentWithSkill($name, $login, $skills);
    }
}