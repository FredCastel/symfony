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
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\AccountListQueryDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\CloseAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\OpenAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\RegisterBankAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\RegisterCashAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\RemoveAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\RenameAccountOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\SetAccountBalanceLimitsOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\SetAccountInitialBalanceOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\BankResource;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\CloseAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\OpenAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\RegisterBankAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\RegisterCashAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\RemoveAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\RenameAccountProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\SetAccountBalanceLimitsProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Account\SetAccountInitialBalanceProcessor;
use Banking\Infrastructure\ApiPlatform\State\Provider\Account\AccountListCollectionProvider;
use Banking\Infrastructure\Doctrine\Entity\DoctrineAccount;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\PartyResource;
use Core\Infrastructure\ApiPlatform\State\Provider\ResourceCollectionProvider;
use Core\Infrastructure\ApiPlatform\State\Provider\ResourceItemProvider;

#[ApiResource(
    shortName: 'Account',
    stateOptions: new Options(entityClass: DoctrineAccount::class),
    operations: [
        // getter
        new GetCollection(
            name: '_api_/banking-account/accountList',
            uriTemplate: '/banking-account/accountList',
            normalizationContext: ['iri_only' => false],
            itemUriTemplate: '/banking-account/{id}',
            provider: AccountListCollectionProvider::class,
            output: AccountListQueryDto::class,
        ),

        // Resource Getters
        new GetCollection(
            name: '_api_/banking-account',
            uriTemplate: '/banking-account',
            normalizationContext: ['iri_only' => true],
            itemUriTemplate: '/banking-account/{id}',
            provider: ResourceCollectionProvider::class,
        ),
        new Get(
            name: '_api_/banking-account/{id}',
            uriTemplate: '/banking-account/{id}',
            provider: ResourceItemProvider::class,
            output: AccountResource::class,
        ),
        // commands
        new Post(
            name: '_api_/banking-account/registerBankAccount',
            uriTemplate: 'banking-account/registerBankAccount',
            normalizationContext: ['iri_only' => true],
            provider: ResourceItemProvider::class,
            processor: RegisterBankAccountProcessor::class,
            input: RegisterBankAccountOperationDto::class,
        ),
        new Post(
            name: '_api_/banking-account/registerCashAccount',
            uriTemplate: 'banking-account/registerCashAccount',
            normalizationContext: ['iri_only' => true],
            provider: ResourceItemProvider::class,
            processor: RegisterCashAccountProcessor::class,
            input: RegisterCashAccountOperationDto::class,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/openAccount',
            uriTemplate: 'banking-account/{id}/openAccount',
            provider: ResourceItemProvider::class,
            processor: OpenAccountProcessor::class,
            input: OpenAccountOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/closeAccount',
            uriTemplate: 'banking-account/{id}/closeAccount',
            provider: ResourceItemProvider::class,
            processor: CloseAccountProcessor::class,
            input: CloseAccountOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/renameAccount',
            uriTemplate: 'banking-account/{id}/renameAccount',
            provider: ResourceItemProvider::class,
            processor: RenameAccountProcessor::class,
            input: RenameAccountOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/setAccountInitialBalance',
            uriTemplate: 'banking-account/{id}/setAccountInitialBalance',
            provider: ResourceItemProvider::class,
            processor: SetAccountInitialBalanceProcessor::class,
            input: SetAccountInitialBalanceOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-account/{id}/setAccountBalanceLimits',
            uriTemplate: 'banking-account/{id}/setAccountBalanceLimits',
            provider: ResourceItemProvider::class,
            processor: SetAccountBalanceLimitsProcessor::class,
            input: SetAccountBalanceLimitsOperationDto::class,
            output: false,
        ),
        new Delete(
            name: '_api_/banking-account/{id}/removeAccount',
            uriTemplate: 'banking-account/{id}/removeAccount',
            provider: ResourceItemProvider::class,
            processor: RemoveAccountProcessor::class,
            input: RemoveAccountOperationDto::class,
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
