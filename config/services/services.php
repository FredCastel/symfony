<?php

// config/services.php
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Banking\Domain\Repository\Account\AccountAggregateRepository;
use Banking\Domain\Repository\Account\AccountEntityRepository;
use Banking\Domain\Repository\Account\OperationEntityRepository;
use Banking\Domain\Repository\Bank\BankAggregateRepository;
use Banking\Domain\Repository\Bank\BankEntityRepository;
use Banking\Infrastructure\Doctrine\Repository\Account\DoctrineAccountAggregateRepository;
use Banking\Infrastructure\Doctrine\Repository\Account\DoctrineAccountEntityRepository;
use Banking\Infrastructure\Doctrine\Repository\Account\DoctrineOperationEntityRepository;
use Banking\Infrastructure\Doctrine\Repository\Bank\DoctrineBankAggregateRepository;
use Banking\Infrastructure\Doctrine\Repository\Bank\DoctrineBankEntityRepository;
use Cluster\Domain\Repository\Party\PartyAggregateRepository;
use Cluster\Domain\Repository\Party\PartyEntityRepository;
use Cluster\Infrastructure\Doctrine\Repository\Party\DoctrinePartyAggregateRepository;
use Cluster\Infrastructure\Doctrine\Repository\Party\DoctrinePartyEntityRepository;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandValidator;
use Core\Application\Command\CommandVoter;
use Core\Application\Event\EventHandler;
use Core\Application\Query\QueryHandler;
use Core\Domain\Repository\Dependencies;
use Core\Domain\Repository\Dependency;
use Core\Infrastructure\Doctrine\DoctrineIdGenerator;
use Core\Infrastructure\Doctrine\EntityDatesListener;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\Bus\Command\CommandBusFactory;
use Core\Service\Bus\Event\EventBus;
use Core\Service\Bus\Event\EventBusFactory;
use Core\Service\Bus\Query\QueryBus;
use Core\Service\Bus\Query\QueryBusFactory;
use Core\Service\IdGenerator;
use DataFixtures\Banking\BankFixtures;
use Maker\Maker\ApiCollectionProviderMaker;
use Maker\Maker\ApiItemProviderMaker;
use Maker\Maker\ApiMaker;
use Maker\Maker\ApiProcessorMaker;
use Maker\Maker\ApiResourceMaker;
use Maker\Maker\ApiResourceOperationDtoMaker;
use Maker\Maker\ApiResourceQueryDtoMaker;
use Maker\Maker\ApplicationCommandAggregateGetterMaker;
use Maker\Maker\ApplicationCommandEntityGetterMaker;
use Maker\Maker\ApplicationCommandHandlerAbstractMaker;
use Maker\Maker\ApplicationCommandHandlerMaker;
use Maker\Maker\ApplicationCommandRequestMaker;
use Maker\Maker\ApplicationCommandVoterMaker;
use Maker\Maker\ApplicationMaker;
use Maker\Maker\DoctrineAggregateRepositoryMaker;
use Maker\Maker\DoctrineEntityMaker;
use Maker\Maker\DoctrineEntityRepositoryMaker;
use Maker\Maker\DoctrineEventHandlerMaker;
use Maker\Maker\DoctrineMaker;
use Maker\Maker\DoctrineMapperMaker;
use Maker\Maker\DomainAggregateMaker;
use Maker\Maker\DomainAggregateRepositoryMaker;
use Maker\Maker\DomainDependencyMaker;
use Maker\Maker\DomainEntityAbstractMaker;
use Maker\Maker\DomainEntityMaker;
use Maker\Maker\DomainEntityRepositoryMaker;
use Maker\Maker\DomainEventMaker;
use Maker\Maker\DomainMaker;
use Maker\Maker\DomainValueObjectMaker;
use Maker\Maker\FullMaker;
use Maker\Maker\MakerCollection;

return function (ContainerConfigurator $containerConfigurator, string $env) {
    $services = $containerConfigurator->services();
    // this config only applies to the services created by this file

    $services->defaults()
        ->autowire() // Automatically injects dependencies in your services.
        ->autoconfigure(); // Automatically registers your services as commands, event subscribers, etc.


    $path = dirname(__DIR__, 2); //'/srv/app';

    /** MAKER */
    $services
        ->set(MakerCollection::class)
        ->lazy();

    $services
        ->set(FullMaker::class)
        ->tag('maker.command');
    //Domain makers
    $services
        ->set(DomainMaker::class)
        ->tag('maker.command');
    $services
        ->set(DomainAggregateMaker::class)
        ->tag('maker.command');
    $services
        ->set(DomainEntityMaker::class)
        ->tag('maker.command');
    $services
        ->set(DomainEntityAbstractMaker::class)
        ->tag('maker.command');
    $services
        ->set(DomainEventMaker::class)
        ->tag('maker.command');
    $services
        ->set(DomainValueObjectMaker::class)
        ->tag('maker.command');
    $services
        ->set(DomainDependencyMaker::class)
        ->tag('maker.command');
    $services
        ->set(DomainAggregateRepositoryMaker::class)
        ->tag('maker.command');
    $services
        ->set(DomainEntityRepositoryMaker::class)
        ->tag('maker.command');

    //Application makers
    $services
        ->set(ApplicationMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApplicationCommandRequestMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApplicationCommandEntityGetterMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApplicationCommandAggregateGetterMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApplicationCommandVoterMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApplicationCommandHandlerAbstractMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApplicationCommandHandlerMaker::class)
        ->tag('maker.command');

    //Doctrine makers
    $services
        ->set(DoctrineMaker::class)
        ->tag('maker.command');
    $services
        ->set(DoctrineEntityMaker::class)
        ->tag('maker.command');
    $services
        ->set(DoctrineAggregateRepositoryMaker::class)
        ->tag('maker.command');
    $services
        ->set(DoctrineEntityRepositoryMaker::class)
        ->tag('maker.command');
    $services
        ->set(DoctrineMapperMaker::class)
        ->tag('maker.command');
    $services
        ->set(DoctrineEventHandlerMaker::class)
        ->tag('maker.command');

    //Api makers
    $services
        ->set(ApiMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApiResourceOperationDtoMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApiResourceQueryDtoMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApiResourceMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApiItemProviderMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApiCollectionProviderMaker::class)
        ->tag('maker.command');
    $services
        ->set(ApiProcessorMaker::class)
        ->tag('maker.command');
    

    /*
     * CommandHandler command Validator
     * autowire all the command handlers and validators
     */

    //events    
    $services
        ->instanceof(EventHandler::class)
        ->tag('ddd.event_handler');
    $services->set(EventBusFactory::class);
    $services->set(EventBus::class)
        ->factory([service(EventBusFactory::class), 'build'])
        // inject all services tagged with app.handler as first argument and validor at 2nd
        ->args(
            [
                tagged_iterator('ddd.event_handler'),
            ]
        );

    //commands

    // services whose classes are instances of CommandHandler will be tagged automatically
    //but service must be set after this line of code
    $services
        ->instanceof(CommandHandler::class)
        ->tag('ddd.command_handler');
    $services
        ->instanceof(CommandValidator::class)
        ->tag('ddd.command_validator');
    $services
        ->instanceof(CommandVoter::class)
        ->tag('ddd.command_voter');

    $services->set(CommandBusFactory::class);
    $services->set(CommandBus::class)
        ->factory([service(CommandBusFactory::class), 'build'])
        // inject all services tagged with app.handler as first argument and validor at 2nd
        ->args(
            [
                tagged_iterator('ddd.command_handler'),
                tagged_iterator('ddd.command_validator'),
                tagged_iterator('ddd.command_voter'),
                service('doctrine.orm.default_entity_manager'),
                service(EventBus::class)
            ]
        )
        ->public()
    ;

    //queries
    $services
        ->instanceof(QueryHandler::class)
        ->tag('ddd.query_handler');
    $services->set(QueryBusFactory::class);
    $services->set(QueryBus::class)
        ->factory([service(QueryBusFactory::class), 'build'])
        // inject all services tagged with app.handler as first argument and validor at 2nd
        ->args(
            [
                tagged_iterator('ddd.query_handler'),
            ]
        )
    ;

    /*
     **************************************
     * Domain
     **************************************
     */


    /*
     **************************************
     * Application
     **************************************
     */
    // command
    $services->load('Banking\\Application\\Command\\', "$path/src/Banking/Application/Command/")
        ->exclude([
            "$path/src/Banking/Application/Command/*/_Tools/",
            "$path/src/Banking/Application/Command/*/*/*Request.php",
            "$path/src/Banking/Application/Command/*/*/Abstract*.php",
            "$path/src/Banking/Application/Command/*/*/_Tools/",
        ])
        ->public();
    $services->load('Cluster\\Application\\Command\\', "$path/src/Cluster/Application/Command/")
        ->exclude([
            "$path/src/Cluster/Application/Command/*/_Tools/",
            "$path/src/Cluster/Application/Command/*/*/*Request.php",
            "$path/src/Cluster/Application/Command/*/*/_Tools/",
        ])
        ->public();


    //  If you're using PHP configuration, you need to call instanceof before any service registration to make sure tags are correctly applied.
    $services
        ->instanceof(Dependency::class)
        ->tag('ddd.dependency');


    /*
     **************************************
     * Infrastructure
     **************************************
     */

    // core
    $services->load('Core\\Infrastructure\\Symfony\\Controller\\', "$path/src/Core/Infrastructure/Symfony/Controller/")
        ->tag('controller.service_arguments');

    /**
     *                 --------------    DOCTRINE        -------------- 
     */

    // banking
    $services->load('Banking\\Infrastructure\\Doctrine\\Mapper\\', "$path/src/Banking/Infrastructure/Doctrine/Mapper/");
    $services->load('Banking\\Infrastructure\\Doctrine\\Repository\\', "$path/src/Banking/Infrastructure/Doctrine/Repository/")
        ->public();
    $services->set(AccountAggregateRepository::class)->class(DoctrineAccountAggregateRepository::class);
    $services->set(AccountEntityRepository::class)->class(DoctrineAccountEntityRepository::class);
    $services->set(OperationEntityRepository::class)->class(DoctrineOperationEntityRepository::class);

    $services->set(BankAggregateRepository::class)->class(DoctrineBankAggregateRepository::class);
    $services->set(BankEntityRepository::class)->class(DoctrineBankEntityRepository::class);

    // Cluster
    $services->load('Cluster\\Infrastructure\\Doctrine\\Mapper\\', "$path/src/Cluster/Infrastructure/Doctrine/Mapper/");
    $services->load('Cluster\\Infrastructure\\Doctrine\\Repository\\', "$path/src/Cluster/Infrastructure/Doctrine/Repository/")
        ->public();
    $services->set(PartyAggregateRepository::class)->class(DoctrinePartyAggregateRepository::class);
    $services->set(PartyEntityRepository::class)->class(DoctrinePartyEntityRepository::class);
    

    //repositories
    $services->set(Dependencies::class)
        ->autowire(false)
        ->arg('$dependencies', tagged_iterator('ddd.dependency'));

    //events handlers    
    $services->load('Banking\\Infrastructure\\Doctrine\\EventHandler\\', "$path/src/Banking/Infrastructure/Doctrine/EventHandler/")
        ->public();
    $services->load('Cluster\\Infrastructure\\Doctrine\\EventHandler\\', "$path/src/Cluster/Infrastructure/Doctrine/EventHandler/")
        ->public();

    //the id Generator to used is the doctrine one
    $services->set(DoctrineIdGenerator::class)->public();
    $services->set(IdGenerator::class)->class(DoctrineIdGenerator::class);

    // listeners are applied by default to all Doctrine connections
    // https://symfony.com/doc/current/doctrine/events.html#doctrine-lifecycle-listeners
    $services->set(EntityDatesListener::class)
        ->tag('doctrine.event_listener', [
            // this is the only required option for the lifecycle listener tag
            'event' => 'prePersist',
            // listeners can define their priority in case multiple subscribers or listeners are associated
            // to the same event (default priority = 0; higher numbers = listener is run earlier)
            'priority' => 500,
            # you can also restrict listeners to a specific Doctrine connection
            'connection' => 'default',
        ])
        ->tag('doctrine.event_listener', [
            'event' => 'preUpdate',
            'priority' => 500,
            'connection' => 'default',
        ])
    ;

    /**
     *                 --------------    API-PLATFORM        -------------- 
     */
    $services->load('Core\\Infrastructure\\ApiPlatform\\', "$path/src/Core/Infrastructure/ApiPlatform/");
    $services->load('Banking\\Infrastructure\\ApiPlatform\\', "$path/src/Banking/Infrastructure/ApiPlatform/");
    $services->load('Cluster\\Infrastructure\\ApiPlatform\\', "$path/src/Cluster/Infrastructure/ApiPlatform/");
 

    /**
     * FIXTURES
     */
    // $services->load('DataFixtures\\', "$path/dataFixtures/");
    // $services->load('DataFixtures\\Banking\\', "$path/dataFixtures/Banking/");
    // $services->load('DataFixtures\\Cluster\\', "$path/dataFixtures/Cluster/");
    // $services->load('DataFixtures\\Business\\', "$path/dataFixtures/Business/");
    // $services->set(BankFixtures::class)->public()->tag('doctrine.fixture.orm');

    /**
     * FRONTEND
     */

};