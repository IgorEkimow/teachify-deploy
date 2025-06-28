<?php

namespace App\Controller\Web\Student\Get\GetById\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetStudentDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public int $id
    ) {
    }
}