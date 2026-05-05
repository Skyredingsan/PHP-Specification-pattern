<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Specification\Order\Composite\OrderCanBeShippedSpecification;

final readonly class ShippingService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private OrderCanBeShippedSpecification $shippingRule,
    ) {}

    public function ship(Order $order): void
    {
        // Вместо лапши из IF — чистый вызов
        if (!$this->shippingRule->isSatisfiedBy($order)) {
            throw new \DomainException(
                'Order cannot be shipped due to business constraints.'
            );
        }

        $order->setStatus(Order::STATUS_SHIPPING);
        $this->orderRepository->save($order);
    }
}