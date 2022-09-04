<?php

namespace App\Service\Catalog;

interface ProductService
{
    public function add(string $name, int $price, int $maxQuantity): Product;

    public function remove(string $id): void;

    public function patch(string $id, string $name, int $price, int $maxQuantity): Product;
}