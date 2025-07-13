<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'student_skill')]
#[ORM\Entity]
#[ORM\Index(name: 'student_skill_student_id_ind', columns: ['student_id'])]
#[ORM\Index(name: 'student_skill_skill_id_ind', columns: ['skill_id'])]
#[ApiResource]
class StudentSkill implements EntityInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: "Student", inversedBy: "skills")]
    #[ORM\JoinColumn(nullable: false)]
    private Student $student;

    #[ORM\ManyToOne(targetEntity: "Skill", inversedBy: "studentSkills")]
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

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): void
    {
        $this->student = $student;
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