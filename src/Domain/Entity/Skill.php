<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'skill')]
#[ORM\Entity]
#[ORM\Index(name: 'skill_name_ind', columns: ['name'])]
class Skill implements EntityInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $name;

    #[ORM\OneToMany(targetEntity: "StudentSkill", mappedBy: "skill")]
    private Collection $studentSkills;

    #[ORM\OneToMany(targetEntity: "TeacherSkill", mappedBy: "skill")]
    private Collection $teacherSkills;

    public function __construct()
    {
        $this->studentSkills = new ArrayCollection();
        $this->teacherSkills = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getStudentSkills(): Collection
    {
        return $this->studentSkills;
    }

    public function addStudentSkill(StudentSkill $studentSkill): void
    {
        if (!$this->studentSkills->contains($studentSkill)) {
            $this->studentSkills[] = $studentSkill;
            $studentSkill->setSkill($this);
        }
    }

    public function removeStudentSkill(StudentSkill $studentSkill): void
    {
        if ($this->studentSkills->removeElement($studentSkill)) {
            if ($studentSkill->getSkill() === $this) {
                $studentSkill->setSkill(null);
            }
        }
    }

    public function getTeacherSkills(): Collection
    {
        return $this->teacherSkills;
    }

    public function addTeacherSkill(TeacherSkill $teacherSkill): void
    {
        if (!$this->teacherSkills->contains($teacherSkill)) {
            $this->teacherSkills[] = $teacherSkill;
            $teacherSkill->setSkill($this);
        }
    }

    public function removeTeacherSkill(TeacherSkill $teacherSkill): void
    {
        if ($this->teacherSkills->removeElement($teacherSkill)) {
            if ($teacherSkill->getSkill() === $this) {
                $teacherSkill->setSkill(null);
            }
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}