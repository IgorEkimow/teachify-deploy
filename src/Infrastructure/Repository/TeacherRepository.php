<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Teacher;

/**
 * @extends AbstractRepository<Teacher>
 */
class TeacherRepository extends AbstractRepository
{
    public function create(Teacher $teacher): int
    {
        return $this->store($teacher);
    }
}