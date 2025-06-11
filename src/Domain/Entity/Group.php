<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'group')]
#[ORM\Entity]
//#[ORM\Entity(repositoryClass: "App\Infrastructure\Repository\GroupRepository")]
class Group
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: "Teacher", inversedBy: "groups")]
    private ?Teacher $teacher = null;

    #[ORM\OneToMany(targetEntity: "Student", mappedBy: "group")]
    private Collection $students;

    #[ORM\ManyToMany(targetEntity: "Skill")]
    #[ORM\JoinTable(name: "group_skills")]
    private Collection $skills;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->skills = new ArrayCollection();
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

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): void
    {
        $this->teacher = $teacher;
    }

    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function getSkills(): Collection
    {
        return $this->skills;
    }
}