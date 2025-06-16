<?php

namespace App\Domain\Service;

use App\Domain\Entity\Teacher;

class TeacherBuilderService
{
    public function __construct(
        private readonly TeacherService $teacherService,
        private readonly SkillService $skillService,
        private readonly TeacherSkillService $teacherSkillService
    ) {
    }

    /**
     * @param string[] $skills
     */
    public function createTeacherWithSkill(string $name, string $login, array $skills): Teacher
    {
        $teacher = $this->teacherService->create($name, $login);

        foreach ($skills as $skillName) {
            $skill = $this->skillService->findSkillByName($skillName) ?? $this->skillService->create($skillName);
            $teacherSkill = $this->teacherSkillService->create($teacher, $skill);
            $teacher->addSkill($teacherSkill);
        }

        return $teacher;
    }
}