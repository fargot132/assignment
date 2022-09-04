<?php

namespace App\Listener;

use App\Entity\Product;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class ProductListener extends AbstractEntityListener
{
    public function prePersist(Product $item, LifecycleEventArgs $args) : void
    {
        $this->setDatesOnCreate($item);
    }

    public function preUpdate(Product $item, PreUpdateEventArgs $args) : void
    {
        $this->setDatesOnUpdate($item);
    }
}