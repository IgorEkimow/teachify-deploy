<?php

namespace App\Controller\Web\CreateTeacher\v1;

use App\Domain\Entity\Teacher;
use App\Domain\Service\TeacherBuilderService;

class Manager
{
    public function __construct(private readonly TeacherBuilderService $teacherBuilderService)
    {
    }

    public function create(string $name, string $login, array $skills): ?Teacher
    {
        return $this->teacherBuilderService->createTeacherWithSkill($name, $login, $skills);
    }
}