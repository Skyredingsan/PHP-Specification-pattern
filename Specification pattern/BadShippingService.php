<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\User;
use App\Repository\OrderRepository;

class BadShippingService
{
    public function __construct(
            private readonly OrderRepository $orderRepository,
    ) {}

    public function canShip(Order $order): bool
    {
        // Проверка 1: Пользователь должен быть активен
        if ($order->getUser()?->getStatus() !== User::STATUS_ACTIVE) {
            return false;
        }

        // Проверка 2: Email должен быть подтвержден
        if (!$order->getUser()?->isEmailVerified()) {
            return false;
        }

        // Проверка 3: Заказ не отменен и не доставлен ранее
        if ($order->getStatus() === Order::STATUS_CANCELLED
                || $order->getStatus() === Order::STATUS_DELIVERED) {
            return false;
        }

        // Проверка 4: Только для премиум-клиентов с суммой > 1000
        if ($order->getUser()?->getTier() === User::TIER_PREMIUM
                && $order->getTotal() > 1000) {
            return true;
        }

        // Проверка 5: Базовая доставка для обычных пользователей при сумме > 5000
        if ($order->getUser()?->getTier() !== User::TIER_PREMIUM
                && $order->getTotal() > 5000) {
            return true;
        }

        // Проверка 6: Склад должен быть в той же стране
        if ($order->getWarehouse()?->getCountry() !== $order->getShippingAddress()?->getCountry()) {
            return false;
        }

        return false;
    }

    public function ship(Order $order): void
    {
        if (!$this->canShip($order)) {
            throw new \DomainException('Order cannot be shipped due to business rules.');
        }

        $order->setStatus(Order::STATUS_SHIPPING);
        $this->orderRepository->save($order);
    }
}