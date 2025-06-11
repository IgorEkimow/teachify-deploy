<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'skill')]
#[ORM\Entity]
// #[ORM\Entity(repositoryClass: "App\Infrastructure\Repository\SkillRepository")]
class Skill
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'text', length: 255, nullable: true)]
    private ?string $description = null;

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStudentSkills(): Collection
    {
        return $this->studentSkills;
    }

    public function getTeacherSkills(): Collection
    {
        return $this->teacherSkills;
    }
}