<?php

namespace App\Controller\Web\Student\Create\v1;

use App\Controller\Web\Student\Create\v1\Input\CreateStudentDTO;
use App\Controller\Web\Student\Create\v1\Output\CreatedStudentDTO;
use App\Domain\Model\CreateStudentModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\StudentService;
use App\Domain\Service\StudentBuilderService;

readonly class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateStudentModel> */
        private ModelFactory $modelFactory,
        private StudentService $studentService,
        private StudentBuilderService $studentBuilderService
    ) {
    }

    public function create(CreateStudentDTO $createStudentDTO): CreatedStudentDTO
    {
        $createStudentModel = $this->modelFactory->makeModel(
            CreateStudentModel::class,
            trim($createStudentDTO->name),
            trim($createStudentDTO->login),
            trim($createStudentDTO->password),
            $createStudentDTO->skills,
            $createStudentDTO->roles
        );
        $student = $this->studentService->findByLogin($createStudentModel) ?? $this->studentBuilderService->createStudentWithSkill($createStudentModel);

        return new CreatedStudentDTO(
            $student->getId(),
            $student->getName(),
            $student->getLogin(),
            $student->getCreatedAt()->format('Y-m-d H:i:s'),
            $student->getUpdatedAt()->format('Y-m-d H:i:s'),
            $student->getSkills()->map(function($studentSkill) {
                return $studentSkill->getSkill()->getName();
            })->toArray(),
            $student->getRoles()
        );
    }
}