<?php

namespace App\Controller\Web\Teacher\Get\GetById\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetTeacherDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public int $id
    ) {
    }
}