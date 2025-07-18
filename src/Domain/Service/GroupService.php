<?php

namespace App\Domain\Service;

use App\Domain\Bus\AssignTeacherBusInterface;
use App\Domain\DTO\AssignTeacherDTO;
use App\Domain\Entity\Group;
use App\Domain\Model\CreateGroupModel;
use App\Domain\Model\GetGroupModel;
use App\Domain\Model\TeacherMatchingCriteria;
use App\Domain\Model\UpdateNameGroupModel;
use App\Infrastructure\Repository\GroupRepository;
use App\Infrastructure\Repository\TeacherRepository;
use App\Infrastructure\Repository\GroupRepositoryCacheDecorator;

readonly class GroupService
{
    public function __construct(
        private SkillService $skillService,
        private GroupRepository $groupRepository,
        private TeacherRepository $teacherRepository,
        private GroupRepositoryCacheDecorator $cacheDecorator,
        private AssignTeacherBusInterface $assignTeacherBus,
    ) {
    }

    public function create(CreateGroupModel $createGroupModel): Group
    {
        $group = new Group();
        $group->setName($createGroupModel->name);
        $group->setCreatedAt();
        $group->setUpdatedAt();

        $this->groupRepository->create($group);
        $this->cacheDecorator->clearCache();

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
        $this->assignTeacherAsync(new AssignTeacherDTO($group->getId()));
        $this->cacheDecorator->clearCache();

        return $group;
    }

    public function findById(GetGroupModel $getGroupModel): ?Group
    {
        return $this->groupRepository->find($getGroupModel->id);
    }

    public function findByName(CreateGroupModel $createGroupModel): ?Group
    {
        $group = $this->groupRepository->findByName($createGroupModel->name);
        return $group[0] ?? null;
    }

    public function find($id): ?Group
    {
        return $this->groupRepository->find($id);
    }

    public function findAll(): array
    {
        return $this->groupRepository->findAll();
    }

    public function updateName(Group $group, UpdateNameGroupModel $updateNameGroupModel): void
    {
        $this->groupRepository->updateName($group, $updateNameGroupModel->name);
        $this->cacheDecorator->clearCache();
    }

    public function remove(Group $group): void
    {
        $this->groupRepository->remove($group);
        $this->cacheDecorator->clearCache();
    }

    public function assignTeacher(Group $group): void
    {
        $criteria = new TeacherMatchingCriteria(maxGroupsPerTeacher: 5, minSkillCoverage: 0.5);

        $teacherMatcher = new TeacherMatcherService($this->teacherRepository);
        $bestTeacher = $teacherMatcher->findBestMatchForGroup($group, $criteria);

        if ($bestTeacher !== null) {
            $group->setTeacher($bestTeacher);
            $this->groupRepository->update($group);
            $this->cacheDecorator->clearCache();
        }
    }

    public function assignTeacherAsync(AssignTeacherDTO $assignTeacherDTO): int
    {
        return $this->assignTeacherBus->sendAssignTeacherMessage($assignTeacherDTO) ? $assignTeacherDTO->id : 0;
    }
}