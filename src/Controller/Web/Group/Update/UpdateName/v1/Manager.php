<?php

namespace App\Controller\Web\Group\Update\UpdateName\v1;

use App\Controller\Web\Group\Update\UpdateName\v1\Input\UpdateNameGroupDTO;
use App\Domain\Entity\Group;
use App\Domain\Model\UpdateNameGroupModel;
use App\Domain\Service\GroupService;
use App\Domain\Service\ModelFactory;

readonly class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateNameGroupModel> */
        private ModelFactory $modelFactory,
        private GroupService $groupService
    ) {
    }

    public function updateName(Group $group, UpdateNameGroupDTO $updateNameGroupDTO): void
    {
        $updateNameGroupModel = $this->modelFactory->makeModel(
            UpdateNameGroupModel::class,
            trim($updateNameGroupDTO->name)
        );
        $this->groupService->updateName($group, $updateNameGroupModel);
    }
}