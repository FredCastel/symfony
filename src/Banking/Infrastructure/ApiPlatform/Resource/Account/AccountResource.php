<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\BankResource;
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
