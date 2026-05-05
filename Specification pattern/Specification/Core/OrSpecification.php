<?php

declare(strict_types=1);

namespace App\Specification\Core;

use App\Specification\Contract\SpecificationInterface;

final readonly class OrSpecification extends AbstractSpecification
{
    public function __construct(
        private SpecificationInterface $left,
        private SpecificationInterface $right,
    ) {}

    public function isSatisfiedBy(mixed $candidate): bool
    {
        return $this->left->isSatisfiedBy($candidate)
            || $this->right->isSatisfiedBy($candidate);
    }
}