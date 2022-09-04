<?php

namespace App\Entity;

use App\Service\Catalog\Product;
use ArrayIterator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Cart implements \App\Service\Cart\Cart
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartProduct::class, cascade: ["persist", "remove"])]
    private Collection $cartProducts;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->cartProducts = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTotalPrice(): int
    {
        return array_reduce(
            $this->getCartProducts()->toArray(),
            static fn(int $total, CartProduct $cartProduct): int => $total + $cartProduct->getQuantity() * $cartProduct->getProduct()->getPrice(),
            0
        );
    }

    #[Pure]
    public function isFull(): bool
    {
        return $this->getProducts()->count() >= self::CAPACITY;
    }

    public function getProducts(): ArrayIterator
    {
        $products = new ArrayCollection();
        foreach ($this->cartProducts as $cartProduct) {
            $products->add($cartProduct->getProduct());
        }
        return $products->getIterator();
    }

    #[Pure]
    public function hasProduct(\App\Entity\Product $product): bool
    {
        return $this->getCartProducts()->exists(fn($key, $value) => $value->getProduct()->getId() === $product->getId());
    }

    public function addProduct(\App\Entity\Product $product): void
    {
        foreach ($this->getCartProducts() as $cartProduct) {
            if ($cartProduct->getProduct()->getId() === $product->getId()) {
                $cartProduct->setQuantity($cartProduct->getQuantity() + 1);
                var_dump($cartProduct);
                return;
            }
        }

        $cartProduct = new CartProduct($this, $product);
        $this->cartProducts->add($cartProduct);

    }

    public function removeProduct(\App\Entity\Product $product): void
    {
        $cartProducts = $this->getCartProducts()->filter(
            fn($item) => $item->getProduct()->getId() === $product->getId()
        );

        foreach ($cartProducts as $cartProduct)
        {
            $this->cartProducts->removeElement($cartProduct);
        }

    }

    /**
     * @return Collection
     */
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }
}
