<?php

declare(strict_types=1);

namespace App\Specification\User;

use App\Entity\User;
use App\Specification\Core\AbstractSpecification;

final readonly class EmailIsVerifiedSpecification extends AbstractSpecification
{
    public function isSatisfiedBy(mixed $candidate): bool
    {
        return $candidate instanceof User
            && $candidate->isEmailVerified();
    }
}