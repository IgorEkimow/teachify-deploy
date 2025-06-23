<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\StudentSkill;

/**
 * @extends AbstractRepository<StudentSkill>
 */
class StudentSkillRepository extends AbstractRepository
{
    public function create(StudentSkill $skill): int
    {
        return $this->store($skill);
    }
}