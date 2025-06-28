<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetStudentModel
{
    public function __construct(
        #[Assert\NotBlank]
        public int $id
    ) {
    }
}