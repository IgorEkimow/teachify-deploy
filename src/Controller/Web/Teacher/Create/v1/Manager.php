<?php

namespace App\Controller\Web\Teacher\Create\v1;

use App\Controller\Web\Teacher\Create\v1\Input\CreateTeacherDTO;
use App\Controller\Web\Teacher\Create\v1\Output\CreatedTeacherDTO;
use App\Domain\Model\CreateTeacherModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TeacherService;
use App\Domain\Service\TeacherBuilderService;

readonly class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateTeacherModel> */
        private ModelFactory $modelFactory,
        private TeacherService $teacherService,
        private TeacherBuilderService $teacherBuilderService
    ) {
    }

    public function create(CreateTeacherDTO $createTeacherDTO) : CreatedTeacherDTO
    {
        $createTeacherModel = $this->modelFactory->makeModel(
            CreateTeacherModel::class,
            trim($createTeacherDTO->name),
            trim($createTeacherDTO->login),
            trim($createTeacherDTO->password),
            $createTeacherDTO->skills,
            $createTeacherDTO->roles
        );
        $teacher = $this->teacherService->findByLogin($createTeacherModel) ?? $this->teacherBuilderService->createTeacherWithSkill($createTeacherModel);

        return new CreatedTeacherDTO(
            $teacher->getId(),
            $teacher->getName(),
            $teacher->getLogin(),
            $teacher->getCreatedAt()->format('Y-m-d H:i:s'),
            $teacher->getUpdatedAt()->format('Y-m-d H:i:s'),
            $teacher->getSkills()->map(function($teacherSkill) {
                return $teacherSkill->getSkill()->getName();
            })->toArray(),
            $teacher->getRoles()
        );
    }
}