<?php

namespace App\Controller\Web\Teacher\Get\GetById\v1;

use App\Controller\Web\Teacher\Get\GetById\v1\Input\GetTeacherDTO;
use App\Controller\Web\Teacher\Get\GetById\v1\Output\GotTeacherDTO;
use App\Domain\Model\GetTeacherModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TeacherService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class Manager
{
    public function __construct(
        /** @var ModelFactory<GetTeacherModel> */
        private ModelFactory $modelFactory,
        private TeacherService $teacherService
    ) {
    }

    public function getTeacherById(GetTeacherDTO $getTeacherDTO): GotTeacherDTO
    {
        $getTeacherModel = $this->modelFactory->makeModel(GetTeacherModel::class, $getTeacherDTO->id);
        $teacher = $this->teacherService->findById($getTeacherModel);

        if ($teacher === null) {
            throw new NotFoundHttpException('Teacher not found');
        }

        return new GotTeacherDTO(
            $teacher->getId(),
            $teacher->getName(),
            $teacher->getLogin(),
            $teacher->getCreatedAt()->format('Y-m-d H:i:s'),
            $teacher->getUpdatedAt()->format('Y-m-d H:i:s'),
            $teacher->getSkills()->map(function($teacherSkill) {
                return $teacherSkill->getSkill()->getName();
            })->toArray()
        );
    }
}