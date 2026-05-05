<?php

declare(strict_types=1);

namespace App\Specification\Order;

use App\Entity\Order;
use App\Specification\Core\AbstractSpecification;

final readonly class OrderTotalGreaterThanSpecification extends AbstractSpecification
{
    public function __construct(
        private float $minTotal
    ) {}

    public function isSatisfiedBy(mixed $candidate): bool
    {
        // Используем современный синтаксис PHP 8.4
        // Важно: мы ожидаем именно Order, а не просто mixed
        return $candidate instanceof Order
            && $candidate->total > $this->minTotal;
    }
}