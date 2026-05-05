<?php

declare(strict_types=1);

namespace App\Specification\Order;

use App\Entity\Order;
use App\Entity\User;
use App\Specification\Core\AbstractSpecification;

final readonly class CustomerIsPremiumSpecification extends AbstractSpecification
{
    public function isSatisfiedBy(mixed $candidate): bool
    {
        return $candidate instanceof Order
            && $candidate->user?->tier === User::TIER_PREMIUM;
    }
}