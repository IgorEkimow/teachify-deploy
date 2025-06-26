<?php

namespace App\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'teacher')]
#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'teacher__login__uniq', columns: ['login'], options: ['where' => '(deleted_at IS NULL)'])]
class Teacher implements EntityInterface, SoftDeletableInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', length: 64, nullable: false)]
    private string $login;

    #[ORM\OneToMany(targetEntity: "TeacherSkill", mappedBy: "teacher")]
    private Collection $skills;

    #[ORM\OneToMany(targetEntity: "Group", mappedBy: "teacher")]
    private Collection $groups;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true)]
    private ?DateTime $deletedAt = null;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->groups = new ArrayCollection();
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

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(TeacherSkill $skill): void
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setTeacher($this);
        }
    }

    public function removeSkill(TeacherSkill $skill): void
    {
        if ($this->skills->removeElement($skill)) {
            if ($skill->getTeacher() === $this) {
                $skill->setTeacher(null);
            }
        }
    }

    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    public function setCreatedAt(): void {
        $this->createdAt = new DateTime();
    }

    public function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): void {
        $this->updatedAt = new DateTime();
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(): void
    {
        $this->deletedAt = new DateTime();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'login' => $this->login,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'skills' => array_map(static fn(TeacherSkill $skills) => $skills->getSkill()->getName(), $this->skills->toArray())
        ];
    }
}