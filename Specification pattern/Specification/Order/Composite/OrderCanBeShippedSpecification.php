<?php

declare(strict_types=1);

namespace App\Specification\Order\Composite;

use App\Specification\Contract\SpecificationInterface;
use App\Specification\Core\AbstractSpecification;
use App\Specification\Order\CustomerIsPremiumSpecification;
use App\Specification\Order\OrderTotalGreaterThanSpecification;
use App\Specification\Order\SameCountrySpecification;
use App\Specification\User\EmailIsVerifiedSpecification;
use App\Specification\User\UserIsActiveSpecification;

final readonly class OrderCanBeShippedSpecification extends AbstractSpecification
{
    public SpecificationInterface $rule;

    public function __construct()
    {
        // Сборка дерева один раз при создании
        $this->rule = $this->buildRule();
    }

    public function isSatisfiedBy(mixed $candidate): bool
    {
        return $this->rule->isSatisfiedBy($candidate);
    }

    private function buildRule(): SpecificationInterface
    {
        return new UserIsActiveSpecification()
            ->and(new EmailIsVerifiedSpecification())
            ->and(new SameCountrySpecification())
            ->and(
                new CustomerIsPremiumSpecification()
                    ->and(new OrderTotalGreaterThanSpecification(1000))
                    ->or(
                        new CustomerIsPremiumSpecification()->not()
                            ->and(new OrderTotalGreaterThanSpecification(5000))
                    )
            );
    }
}