<?php

namespace App\Controller\Web\Student\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateStudentDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $login,
        #[Assert\NotBlank]
        public array $skills
    ) {
    }
}