<?php

namespace App\Domain\Service;

use App\Domain\Entity\Skill;
use App\Infrastructure\Repository\SkillRepository;

class SkillService
{
    public function __construct(private readonly SkillRepository $skillRepository)
    {
    }

    public function create(string $name): Skill
    {
        $skill = new Skill();
        $skill->setName($name);
        $this->skillRepository->create($skill);

        return $skill;
    }

    public function findByName(string $name): ?Skill
    {
        $skills = $this->skillRepository->findSkillByName($name);
        return $skills[0] ?? null;
    }
}