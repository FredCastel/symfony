<?php

namespace Core\Infrastructure\Doctrine\EventHandler;

use Core\Application\Event\EventHandler;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractEventHandler implements EventHandler
{
    public function __construct(
        protected EntityManagerInterface $em,
    ) {
    }
}