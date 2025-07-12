<?php

namespace App\Controller\Web\Group\Get\GetById\v1;

use App\Controller\Web\Group\Get\GetById\v1\Input\GetGroupDTO;
use App\Controller\Web\Group\Get\GetById\v1\Output\GotGroupDTO;
use App\Domain\Model\GetGroupModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\GroupService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    public function __construct(
        /** @var ModelFactory<GetGroupModel> */
        private ModelFactory $modelFactory,
        private GroupService $groupService
    ) {
    }

    public function getGroupById(GetGroupDTO $getGroupDTO): GotGroupDTO
    {
        $getGroupModel = $this->modelFactory->makeModel(
            GetGroupModel::class,
            trim($getGroupDTO->id)
        );
        $group = $this->groupService->findById($getGroupModel);

        if ($group === null) {
            throw new NotFoundHttpException('Group not found');
        }

        return new GotGroupDTO(
            $group->getId(),
            $group->getName(),
            $group->getCreatedAt()->format('Y-m-d H:i:s'),
            $group->getUpdatedAt()->format('Y-m-d H:i:s'),
            $group->getSkills()->map(function($skill) {
                return $skill->getName();
            })->toArray(),
            $group->getStudents()->map(function($student) {
                return $student->getName();
            })->toArray(),
            $group->getTeacher() ? $group->getTeacher()->getName() : ''
        );
    }
}