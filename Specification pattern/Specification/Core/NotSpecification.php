<?php

declare(strict_types=1);

namespace App\Specification\Core;

use App\Specification\Contract\SpecificationInterface;

final readonly class NotSpecification extends AbstractSpecification
{
    public function __construct(
        private SpecificationInterface $specification,
    ) {}

    public function isSatisfiedBy(mixed $candidate): bool
    {
        return !$this->specification->isSatisfiedBy($candidate);
    }
}