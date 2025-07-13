<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Student;

interface StudentRepositoryInterface
{
    /**
     * @return Student[]
     */
    public function getAllCached(): array;
}