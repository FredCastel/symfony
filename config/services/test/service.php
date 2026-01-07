<?php

// config/services.php
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Core\Domain\Repository\Dependencies;
use Core\Domain\Repository\Dependency;
use Core\Infrastructure\Doctrine\DoctrineIdGenerator;
use Core\Infrastructure\InMemory\IntIdGenerator;
use Core\Service\Bus\Command\DispatcherCommandBus;
use Core\Service\IdGenerator;

return function (ContainerConfigurator $containerConfigurator, string $env) {
    $services = $containerConfigurator->services();
    // this config only applies to the services created by this file
    $services->defaults()
        ->autowire() // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
        ->public();


    $path = dirname(__DIR__, 3); //'/srv/app';



    //the id Generator to used is the Mocked one
    // $services->set(IntIdGenerator::class)->public();
    // $services->set(DoctrineIdGenerator::class)->public();
    // $services->set(IdGenerator::class)->class(DoctrineIdGenerator::class);
    // $services->set(DoctrineIdGenerator::class)->class(DoctrineIdGenerator::class)->public();

    //bus
    $services->set(DispatcherCommandBus::class)
        ->args(
            [
                tagged_iterator('ddd.command_handler'),
            ]
        )
        ->public()
    ;

    // $services
    //     ->instanceof(Dependency::class)
    //     ->tag('ddd.dependency');


    // // repositories    

    // $services->set(Dependencies::class)
    //     ->autowire(false)
    //     ->arg('$dependencies', tagged_iterator('ddd.dependency'));

    /**
     *                 --------------    DOCTRINE        -------------- 
     */

    // $services->load('Banking\\Infrastructure\\Doctrine\\Repository\\', "$path/src/Banking/Infrastructure/Doctrine/Repository/");
    // $services->load('Cluster\\Infrastructure\\Doctrine\\Repository\\', "$path/src/Cluster/Infrastructure/Doctrine/Repository/");
    // $services->load('Business\\Infrastructure\\Doctrine\\Repository\\', "$path/src/Business/Infrastructure/Doctrine/Repository/");
};