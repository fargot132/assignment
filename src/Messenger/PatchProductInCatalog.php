<?php

namespace App\Messenger;

class PatchProductInCatalog
{
    public function __construct(
        public readonly string $productId,
        public readonly string $name,
        public readonly int    $price,
        public readonly int    $maxQuantity
    )
    {
    }
}