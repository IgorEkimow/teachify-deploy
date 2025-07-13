<?php

namespace App\Domain\Model;

readonly class TeacherMatchingCriteria
{
    /*
     * maxGroupsPerTeacher - максимальное кол-во групп на преподавателя
     * minSkillCoverage - минимальное покрытие преподавателем навыков группы (например 0.7 - 70% покрытия)
     * */
    public function __construct(
        public int $maxGroupsPerTeacher = 5,
        public float $minSkillCoverage = 0.7
    ) {
    }
}