<?php

namespace App\Domain\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Domain\ValueObject\RoleEnum;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Table(name: 'student')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'student_group_id_ind', columns: ['group_id'])]
#[ORM\UniqueConstraint(name: 'student__login__uniq', columns: ['login'], options: ['where' => '(deleted_at IS NULL)'])]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial', 'login' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['login'])]
class Student implements EntityInterface, SoftDeletableInterface, UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 128, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', length: 64, nullable: false)]
    private string $login;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $password;

    #[ORM\Column(type: 'string', length: 32, unique: true, nullable: true)]
    private ?string $token = null;

    #[ORM\OneToMany(targetEntity: "StudentSkill", mappedBy: "student")]
    private Collection $skills;

     #[ORM\ManyToOne(targetEntity: "Group", inversedBy: "students")]
     private ?Group $group = null;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true)]
    private ?DateTime $deletedAt = null;

    #[ORM\Column(type: 'json', length: 1024, nullable: false)]
    private array $roles = [];

    public function __construct()
    {
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

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(StudentSkill $skill): void
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setStudent($this);
        }
    }

    public function removeSkill(StudentSkill $skill): void
    {
        if ($this->skills->removeElement($skill)) {
            if ($skill->getStudent() === $this) {
                $skill->setStudent(null);
            }
        }
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function setGroup(?Group $group): void
    {
        $this->group = $group;
    }

    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void {
        $this->createdAt = new DateTime();
    }

    public function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
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

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = RoleEnum::ROLE_USER->value;

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'login' => $this->login,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'skills' => array_map(static fn(StudentSkill $skills) => $skills->getSkill()->getName(), $this->skills->toArray()),
            'roles' => $this->roles
        ];
    }
}