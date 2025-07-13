<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Teacher;

interface TeacherRepositoryInterface
{
    /**
     * @return Teacher[]
     */
    public function getAllCached(): array;
}