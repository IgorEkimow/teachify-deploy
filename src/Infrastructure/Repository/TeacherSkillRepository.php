<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\TeacherSkill;

/**
 * @extends AbstractRepository<TeacherSkill>
 */
class TeacherSkillRepository extends AbstractRepository
{
    public function create(TeacherSkill $skill): int
    {
        return $this->store($skill);
    }
}