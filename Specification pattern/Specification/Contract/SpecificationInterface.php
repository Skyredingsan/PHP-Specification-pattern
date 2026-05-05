<?php

declare(strict_types=1);

namespace App\Specification\Contract;

/**
 * @template C
 */
interface SpecificationInterface
{
    /**
     * @param C $candidate
     */
    public function isSatisfiedBy(mixed $candidate): bool;

    /**
     * @param SpecificationInterface<C> $other
     * @return static
     */
    public function and(SpecificationInterface $other): SpecificationInterface;

    /**
     * @param SpecificationInterface<C> $other
     * @return static
     */
    public function or(SpecificationInterface $other): SpecificationInterface;

    /**
     * @return static
     */
    public function not(): SpecificationInterface;
}