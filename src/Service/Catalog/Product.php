<?php

namespace App\Service\Catalog;

use DateTimeImmutable;

interface Product
{
    public function getId(): string;
    public function getName(): string;
    public function setName(string $name): void;
    public function getPrice(): int;
    public function setPrice(string $price): void;
    public function getCreatedAt(): DateTimeImmutable;
    public function setCreatedAt(DateTimeImmutable $createdAt): void;
    public function getUpdatedAt(): DateTimeImmutable;
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void;
    public function getMaxQuantity(): int;
    public function setMaxQuantity(int $maxQuantity): void;

}
