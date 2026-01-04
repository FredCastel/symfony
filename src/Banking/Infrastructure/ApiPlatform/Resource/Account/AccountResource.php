<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\closeAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\openAccounOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\registerBankAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\registerCashAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\removeAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\renameAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\setAccountBalanceLimitsOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\setAccountInitialBalanceOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\BankResource;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\closeAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\openAccounProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\registerBankAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\registerCashAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\removeAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\renameAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\setAccountBalanceLimitsProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\setAccountInitialBalanceProcessor;
use Banking\Infrastructure\ApiPlatform\State\Provider\Account\listCollectionProvider;
use Banking\Infrastructure\ApiPlatform\State\Provider\Account\RootCollectionProvider;
use Banking\Infrastructure\ApiPlatform\State\Provider\Account\RootItemProvider;
use Banking\Infrastructure\Doctrine\Entity\DoctrineAccount;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\PartyResource;

#[ApiResource(
    shortName: 'Account',
    stateOptions: new Options(entityClass: DoctrineAccount::class),
    operations: [
        // getter

        new Get(
            name: '_api_/banking-account/{id}',
            uriTemplate: '/banking-account/{id}',
            provider: RootItemProvider::class,
            output: AccountResource::class,
        ),

        new GetCollection(
            name: '_api_/banking-account',
            uriTemplate: '/banking-account',
            normalizationContext: ['iri_only' => true],
            itemUriTemplate: '/banking-account/{id}',
            provider: RootCollectionProvider::class,
        ),

        new GetCollection(
            name: '_api_/banking-account/list',
            uriTemplate: '/banking-account/list',
            normalizationContext: ['iri_only' => false],
            itemUriTemplate: '/banking-account/{id}',
            provider: listCollectionProvider::class,
        ),

        // commands
        new Post(
            name: '_api_/banking-account/registerBankAccount',
            uriTemplate: 'banking-account/registerBankAccount',
            normalizationContext: ['iri_only' => true],
            provider: RootItemProvider::class,
            processor: registerBankAccountProcessor::class,
            input: registerBankAccountOperationDto::class,
        ),
        new Post(
            name: '_api_/banking-account/registerCashAccount',
            uriTemplate: 'banking-account/registerCashAccount',
            normalizationContext: ['iri_only' => true],
            provider: RootItemProvider::class,
            processor: registerCashAccountProcessor::class,
            input: registerCashAccountOperationDto::class,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/openAccoun',
            uriTemplate: 'banking-account/{id}/openAccoun',
            provider: RootItemProvider::class,
            processor: openAccounProcessor::class,
            input: openAccounOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/closeAccount',
            uriTemplate: 'banking-account/{id}/closeAccount',
            provider: RootItemProvider::class,
            processor: closeAccountProcessor::class,
            input: closeAccountOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/renameAccount',
            uriTemplate: 'banking-account/{id}/renameAccount',
            provider: RootItemProvider::class,
            processor: renameAccountProcessor::class,
            input: renameAccountOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/setAccountInitialBalance',
            uriTemplate: 'banking-account/{id}/setAccountInitialBalance',
            provider: RootItemProvider::class,
            processor: setAccountInitialBalanceProcessor::class,
            input: setAccountInitialBalanceOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/setAccountBalanceLimits',
            uriTemplate: 'banking-account/{id}/setAccountBalanceLimits',
            provider: RootItemProvider::class,
            processor: setAccountBalanceLimitsProcessor::class,
            input: setAccountBalanceLimitsOperationDto::class,
            output: false,
        ),
        new Delete(
            name: '_api_/banking-account/{id}/removeAccount',
            uriTemplate: 'banking-account/{id}/removeAccount',
            provider: RootItemProvider::class,
            processor: removeAccountProcessor::class,
            input: removeAccountOperationDto::class,
            output: false,
        ),
    ]
)]
final class AccountResource
{
    #[ApiProperty(identifier: true, readable: false, writable: false)]
    public string $id;

    public ?string $name;
    public ?string $state;
    public ?string $category;
    public ?string $currencycode;
    public ?float $balance;
    public ?float $initialbalance;
    public ?float $minimumbalance;
    public ?float $maximumbalance;
    public ?\DateTimeImmutable $validityperiodsince;
    public ?\DateTimeImmutable $validityperioduntil;

    public ?BankResource $bankid;
    public ?PartyResource $partyid;

    public static function mapEntityToDto(?DoctrineAccount $doctrineEntity): ?self
    {
        if (null == $doctrineEntity) {
            return null;
        }

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
        $dto->name = $doctrineEntity->getname();
        $dto->state = $doctrineEntity->getstate();
        $dto->category = $doctrineEntity->getcategory();
        $dto->currencycode = $doctrineEntity->getcurrencycode();
        $dto->balance = $doctrineEntity->getbalance();
        $dto->initialbalance = $doctrineEntity->getinitialbalance();
        $dto->minimumbalance = $doctrineEntity->getminimumbalance();
        $dto->maximumbalance = $doctrineEntity->getmaximumbalance();
        $dto->validityperiodsince = $doctrineEntity->getvalidityperiodsince();
        $dto->validityperioduntil = $doctrineEntity->getvalidityperioduntil();
        $dto->bankid = BankResource::mapEntityToDto($doctrineEntity->getbankid());
        $dto->partyid = PartyResource::mapEntityToDto($doctrineEntity->getpartyid());

        return $dto;
    }
}
