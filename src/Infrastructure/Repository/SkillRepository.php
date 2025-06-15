<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Skill;

/**
 * @extends AbstractRepository<Skill>
 */
class SkillRepository extends AbstractRepository
{
    public function create(Skill $skill): int
    {
        return $this->store($skill);
    }

    public function findSkillByName(string $name): array
    {
        return $this->entityManager->getRepository(Skill::class)->findBy(['name' => $name]);
    }
}