<?php

namespace App\Controller\Web\Student\Get\GetById\v1;

use App\Controller\Web\Student\Get\GetById\v1\Input\GetStudentDTO;
use App\Controller\Web\Student\Get\GetById\v1\Output\GotStudentDTO;
use App\Domain\Model\GetStudentModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\StudentService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    public function __construct(
        /** @var ModelFactory<GetStudentModel> */
        private ModelFactory $modelFactory,
        private StudentService $studentService
    ) {
    }

    public function getStudentById(GetStudentDTO $getStudentDTO): GotStudentDTO
    {
        $getStudentModel = $this->modelFactory->makeModel(
            GetStudentModel::class,
            trim($getStudentDTO->id)
        );
        $student = $this->studentService->findById($getStudentModel);

        if ($student === null) {
            throw new NotFoundHttpException('Student not found');
        }

        return new GotStudentDTO(
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