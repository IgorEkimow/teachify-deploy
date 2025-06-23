<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Student;

/**
 * @extends AbstractRepository<Student>
 */
class StudentRepository extends AbstractRepository
{
    public function create(Student $student): int
    {
        return $this->store($student);
    }
}