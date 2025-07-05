<?php

namespace App\Controller\Web\Group\Create\v1;

use App\Controller\Web\Group\Create\v1\Input\CreateGroupDTO;
use App\Controller\Web\Group\Create\v1\Output\CreatedGroupDTO;
use App\Domain\Model\CreateGroupModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\GroupService;

readonly class Manager {
    public function __construct(
        /** @var ModelFactory<CreateGroupModel> */
        private ModelFactory $modelFactory,
        private GroupService $groupService
    ) {
    }

    public function create(CreateGroupDTO $createGroupDTO) : CreatedGroupDTO
    {
        $createGroupModel = $this->modelFactory->makeModel(
            CreateGroupModel::class,
            trim($createGroupDTO->name)
        );
        $group = $this->groupService->findByName($createGroupModel) ?? $this->groupService->create($createGroupModel);

        return new CreatedGroupDTO(
            $group->getId(),
            $group->getName(),
            $group->getCreatedAt()->format('Y-m-d H:i:s'),
            $group->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }
}