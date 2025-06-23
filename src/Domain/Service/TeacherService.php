<?php

namespace App\Domain\Service;

use App\Domain\Entity\Teacher;
use App\Infrastructure\Repository\TeacherRepository;

class TeacherService
{
    public function __construct(private readonly TeacherRepository $teacherRepository)
    {
    }

    public function create(string $name, string $login): Teacher
    {
        $teacher = new Teacher();
        $teacher->setName($name);
        $teacher->setLogin($login);
        $teacher->setCreatedAt();
        $teacher->setUpdatedAt();
        $this->teacherRepository->create($teacher);

        return $teacher;
    }
}