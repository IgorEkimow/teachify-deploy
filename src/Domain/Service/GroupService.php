<?php

namespace App\Domain\Service;

use App\Domain\Entity\Group;
use App\Domain\Model\CreateGroupModel;
use App\Domain\Model\GetGroupModel;
use App\Domain\Model\UpdateNameGroupModel;
use App\Infrastructure\Repository\GroupRepository;

readonly class GroupService
{
    public function __construct(
        private SkillService $skillService,
        private GroupRepository $groupRepository
    ) {
    }

    public function create(CreateGroupModel $createGroupModel): Group
    {
        $group = new Group();
        $group->setName($createGroupModel->name);
        $group->setCreatedAt();
        $group->setUpdatedAt();
        $this->groupRepository->create($group);

        return $group;
    }

    public function createWithSkills(CreateGroupModel $createGroupModel): Group
    {
        $group = new Group();
        $group->setName($createGroupModel->name);
        $group->setCreatedAt();
        $group->setUpdatedAt();

        foreach ($createGroupModel->skills as $skillName) {
            $skill = $this->skillService->findByName($skillName) ?? $this->skillService->create($skillName);
            $group->addSkill($skill);
        }

        $this->groupRepository->create($group);

        return $group;
    }

    public function findByName(CreateGroupModel $createGroupModel): ?Group
    {
        $group = $this->groupRepository->findGroupByName($createGroupModel->name);
        return $group[0] ?? null;
    }

    public function findById(GetGroupModel $getGroupModel): ?Group
    {
        return $this->groupRepository->find($getGroupModel->id);
    }

    public function findAll(): array
    {
        return $this->groupRepository->findAll();
    }

    public function remove(Group $group): void
    {
        $this->groupRepository->remove($group);
    }

    public function updateName(Group $group, UpdateNameGroupModel $updateNameGroupModel): void
    {
        $this->groupRepository->updateName($group, $updateNameGroupModel->name);
    }
}