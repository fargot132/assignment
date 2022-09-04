<?php

namespace App\Listener;

use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractEntityListener
{
    protected const ENTITY_NAME = '';
    protected  ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    protected function setDatesOnCreate($item) : void
    {
        $now = new DateTimeImmutable();
        $item->setCreatedAt($now);
        $item->setUpdatedAt($now);
    }

    protected function setDatesOnUpdate($item) : void
    {
        $item->setUpdatedAt(new DateTimeImmutable());
    }
}