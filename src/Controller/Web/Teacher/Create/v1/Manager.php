<?php

namespace App\Controller\Web\Teacher\Create\v1;

use App\Domain\Entity\Teacher;
use App\Domain\Service\TeacherService;
use App\Domain\Service\TeacherBuilderService;

class Manager {
    public function __construct(private readonly TeacherService $teacherService, private readonly TeacherBuilderService $teacherBuilderService) {}

    public function createTeacher(string $name, string $login) : ?Teacher {
        return $this->teacherService->create($name, $login);
    }

    public function createTeacherWithSkill(string $name, string $login, array $skills) : ?Teacher {
        return $this->teacherBuilderService->createTeacherWithSkill($name, $login, $skills);
    }
}