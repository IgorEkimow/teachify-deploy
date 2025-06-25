<?php

namespace App\Controller\Web\Student\Update\UpdateLogin\v1;

use App\Controller\Web\Student\Update\UpdateLogin\v1\Input\UpdateLoginStudentDTO;
use App\Domain\Entity\Student;
use App\Domain\Model\UpdateLoginStudentModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\StudentService;

readonly class Manager
{
    public function __construct(
        /** @var ModelFactory<UpdateLoginStudentModel> */
        private ModelFactory $modelFactory,
        private StudentService $studentService
    ) {
    }

    public function updateLogin(Student $student, UpdateLoginStudentDTO $updateLoginStudentDTO): void
    {
        $updateLoginStudentModel = $this->modelFactory->makeModel(UpdateLoginStudentModel::class, $updateLoginStudentDTO->login);
        $this->studentService->updateLogin($student, $updateLoginStudentModel);
    }
}