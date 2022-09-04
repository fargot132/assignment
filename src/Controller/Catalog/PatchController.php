<?php

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\AddProductToCatalog;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\Messenger\PatchProductInCatalog;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/{product}", methods={"PATCH"}, name="product-patch")
 */
class PatchController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct(private ErrorBuilder $errorBuilder) { }

    public function __invoke(?Product $product, Request $request): Response
    {
        if ($product === null) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $name = $request->get('name') ? trim($request->get('name')) : $product->getName();
        $price = (int)$request->get('price') > 1 ? (int)$request->get('price') : $product->getPrice();
        $maxQuantity = (int)$request->get('max_quantity') > 0 ?
            (int)$request->get('max_quantity') : $product->getMaxQuantity();

        $this->dispatch(new PatchProductInCatalog($product->getId(), $name, $price, $maxQuantity));

        return new Response('', Response::HTTP_ACCEPTED);
    }

}