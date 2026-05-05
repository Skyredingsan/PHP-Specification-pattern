<?php
declare(strict_types=1);
namespace App\Specification\Core;
use App\Specification\Contract\SpecificationInterface;
/**
 * Универсальный адаптер для трансформации кандидата
 *
 * @template CFrom
 * @template CTo
 */
final readonly class AdaptSpecification extends AbstractSpecification
{
    /**
     * @param SpecificationInterface<CTo> $inner
     * @param callable(CFrom): (CTo|null) $extractor
     */
    public function __construct(
        private SpecificationInterface $inner,
        private mixed $extractor,
    ) {}
    public function isSatisfiedBy(mixed $candidate): bool
    {
        $innerCandidate = ($this->extractor)($candidate);

        return $innerCandidate !== null
            && $this->inner->isSatisfiedBy($innerCandidate);
    }
}