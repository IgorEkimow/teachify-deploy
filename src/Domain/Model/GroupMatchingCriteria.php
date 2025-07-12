<?php

namespace App\Domain\Model;

readonly class GroupMatchingCriteria
{
    /*
     * requiredSkills - массив навыков
     * maxGroupSize - максимальное кол-во студентов в группе
     * maxIrrelevantSkillRatio - максимальная доля нерелевантных навыков (какая доля навыков в группе может не совпадать с навыками студента, чтобы группа ещё считалась подходящей)
     * maxUnwantedSkillsRatio - максимально допустимая доля ненужных навыков в группе для конкретного студента / 0.2-0.3 (20-30%) - строгий подбор (только очень релевантные группы) / 0.4-0.5 (40-50%) - умеренный подбор
     * */
    public function __construct(
        public array $requiredSkills,
        public int $maxGroupSize = 20,
        public float $maxIrrelevantSkillRatio = 0.3,
        public float $maxUnwantedSkillsRatio = 0.5
    ) {
    }
}