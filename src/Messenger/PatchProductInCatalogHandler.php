<?php

namespace App\Messenger;

use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class PatchProductInCatalogHandler implements MessageHandlerInterface
{
    public function __construct(private ProductService $service) { }

    public function __invoke(PatchProductInCatalog $command): void
    {
        $this->service->patch($command->productId, $command->name, $command->price, $command->maxQuantity);
    }
}