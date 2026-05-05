<?php

declare(strict_types=1);

namespace App\Specification\Order;

use App\Entity\Order;
use App\Specification\Core\AbstractSpecification;

final readonly class SameCountrySpecification extends AbstractSpecification
{
    public function isSatisfiedBy(mixed $candidate): bool
    {
        return $candidate instanceof Order
            && $candidate->warehouse?->country === $candidate->shippingAddress?->country;
    }
}