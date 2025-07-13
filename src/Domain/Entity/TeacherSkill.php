<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'teacher_skill')]
#[ORM\Entity]
#[ORM\Index(name: 'teacher_skill_teacher_id_ind', columns: ['teacher_id'])]
#[ORM\Index(name: 'teacher_skill_skill_id_ind', columns: ['skill_id'])]
#[ApiResource]
class TeacherSkill implements EntityInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: "Teacher", inversedBy: "skills")]
    #[ORM\JoinColumn(nullable: false)]
    private Teacher $teacher;

    #[ORM\ManyToOne(targetEntity: "Skill", inversedBy: "teacherSkills")]
    #[ORM\JoinColumn(nullable: false)]
    private Skill $skill;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTeacher(): Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(Teacher $teacher): void
    {
        $this->teacher = $teacher;
    }

    public function getSkill(): Skill
    {
        return $this->skill;
    }

    public function setSkill(Skill $skill): void
    {
        $this->skill = $skill;
    }
}