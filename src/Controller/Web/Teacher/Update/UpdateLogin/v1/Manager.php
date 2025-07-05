<?php

namespace App\Controller\Web\Teacher\Update\UpdateLogin\v1;

use App\Controller\Web\Teacher\Update\UpdateLogin\v1\Input\UpdateLoginTeacherDTO;
use App\Domain\Entity\Teacher;
use App\Domain\Model\UpdateLoginTeacherModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TeacherService;

readonly class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateLoginTeacherModel> */
        private ModelFactory $modelFactory,
        private TeacherService $teacherService
    ) {
    }

    public function updateLogin(Teacher $teacher, UpdateLoginTeacherDTO $updateLoginTeacherDTO): void
    {
        $updateLoginTeacherModel = $this->modelFactory->makeModel(
            UpdateLoginTeacherModel::class,
            trim($updateLoginTeacherDTO->login)
        );
        $this->teacherService->updateLogin($teacher, $updateLoginTeacherModel);
    }
}