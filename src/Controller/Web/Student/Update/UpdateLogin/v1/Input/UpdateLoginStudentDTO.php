<?php

namespace App\Controller\Web\Student\Update\UpdateLogin\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateLoginStudentDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $login
    ) {
    }
}