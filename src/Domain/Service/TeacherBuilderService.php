<?php

namespace App\Domain\Service;

use App\Domain\Entity\Teacher;
use App\Domain\Model\CreateTeacherModel;

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
    public function createTeacherWithSkill(CreateTeacherModel $createTeacherModel): Teacher
    {
        $teacher = $this->teacherService->create($createTeacherModel->name, $createTeacherModel->login);

        foreach ($createTeacherModel->skills as $skillName) {
            $skill = $this->skillService->findByName($skillName) ?? $this->skillService->create($skillName);
            $teacherSkill = $this->teacherSkillService->create($teacher, $skill);
            $teacher->addSkill($teacherSkill);
        }

        return $teacher;
    }
}