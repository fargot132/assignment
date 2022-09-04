<?php

namespace App\Controller\Catalog;

use App\Messenger\AddProductToCatalog;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products", methods={"POST"}, name="product-add")
 */
class AddController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct(private ErrorBuilder $errorBuilder) { }

    public function __invoke(Request $request): Response
    {
        $name = trim($request->get('name'));
        $price = (int)$request->get('price');
        $maxQuantity = (int)($request->get('max_quantity') ?: 1);

        if ($name === '' || $price < 1 || $maxQuantity < 1) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Invalid name, price or quantity.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->dispatch(new AddProductToCatalog($name, $price, $maxQuantity));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}