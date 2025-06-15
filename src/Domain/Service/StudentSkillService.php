<?php

namespace App\Domain\Service;

use App\Domain\Entity\Skill;
use App\Domain\Entity\Student;
use App\Domain\Entity\StudentSkill;
use App\Infrastructure\Repository\SkillRepository;
use App\Infrastructure\Repository\StudentSkillRepository;

class StudentSkillService
{
    public function __construct(private readonly StudentSkillRepository $studentSkillRepository)
    {
    }

    public function create(Student $student, Skill $skill): StudentSkill
    {
        $studentSkill = new StudentSkill();
        $studentSkill->setStudent($student);
        $studentSkill->setSkill($skill);
        $this->studentSkillRepository->create($studentSkill);

        return $studentSkill;
    }
}