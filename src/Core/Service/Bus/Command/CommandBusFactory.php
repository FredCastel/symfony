<?php

namespace Core\Service\Bus\Command;

use Core\Application\Command\CommandHandler;
use Core\Service\Bus\Event\EventBus;
use Doctrine\ORM\EntityManagerInterface;
use Core\Infrastructure\Doctrine\DoctrineFlushCommandBus;

class CommandBusFactory
{
    static public function build(
        iterable $handlers,
        iterable $validators,
        iterable $voters,
        EntityManagerInterface $entityManager,
        EventBus $eventBus
    ): CommandBus {

        //create each bus instance starting from the last
        $dispatcherBus = new DispatcherCommandBus(
            handlers: $handlers
        );

        $doctrineFlushBus = new DoctrineFlushCommandBus(
            next: $dispatcherBus,
            entityManager: $entityManager
        );

        $eventDispatcherBus = new EventDispatcherBusMiddleware(
            next: $doctrineFlushBus,
            eventBus: $eventBus,
        );

        $validatorBus = new ValidatorCommandBus(
            next: $eventDispatcherBus,
            validators: $validators
        );

        $voterBus = new VoterCommandBus(
            next: $validatorBus,
            voters: $voters
        );

        return $voterBus;
    }
}