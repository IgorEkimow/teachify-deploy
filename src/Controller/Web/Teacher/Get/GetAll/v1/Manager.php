<?php

namespace App\Controller\Web\Teacher\Get\GetAll\v1;

use App\Domain\Repository\TeacherRepositoryInterface;

readonly class Manager
{
    public function __construct(private TeacherRepositoryInterface $teacherRepositoryInterface)
    {
    }

    public function getAll(): array
    {
        return $this->teacherRepositoryInterface->getAllCached();
    }
}