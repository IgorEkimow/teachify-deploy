<?php

namespace App\Controller\Web\Student\Get\GetAll\v1;

use App\Domain\Repository\StudentRepositoryInterface;

readonly class Manager
{
    public function __construct(private StudentRepositoryInterface $studentRepositoryInterface)
    {
    }

    public function getAllStudents(): array
    {
        return $this->studentRepositoryInterface->getAllCached();
    }
}