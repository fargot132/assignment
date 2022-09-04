<?php

namespace App\Service\Cart;

use App\Service\Catalog\Product;
use Doctrine\Common\Collections\Collection;

interface Cart
{
    public function getId(): string;
    public function getTotalPrice(): int;
    public function isFull(): bool;
    /**
     * @return Product[]
     */
    public function getProducts(): iterable;
    public function getCartProducts(): Collection;
}
