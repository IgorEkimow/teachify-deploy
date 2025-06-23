<?php

namespace App\Domain\Service;

use App\Domain\Entity\Skill;
use App\Domain\Entity\Teacher;
use App\Domain\Entity\TeacherSkill;
use App\Infrastructure\Repository\TeacherSkillRepository;

class TeacherSkillService
{
    public function __construct(private readonly TeacherSkillRepository $teacherSkillRepository)
    {
    }

    public function create(Teacher $teacher, Skill $skill): TeacherSkill
    {
        $teacherSkill = new TeacherSkill();
        $teacherSkill->setTeacher($teacher);
        $teacherSkill->setSkill($skill);
        $this->teacherSkillRepository->create($teacherSkill);

        return $teacherSkill;
    }
}