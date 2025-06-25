<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetTeacherModel
{
    public function __construct(
        #[Assert\NotBlank]
        public int $id
    ) {
    }
}