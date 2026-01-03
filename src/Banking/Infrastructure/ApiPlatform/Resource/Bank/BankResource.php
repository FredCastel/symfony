<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Banking\Infrastructure\ApiPlatform\State\Provider\Bank\RootCollectionProvider;
use Banking\Infrastructure\ApiPlatform\State\Provider\Bank\RootItemProvider;
use Banking\Infrastructure\Doctrine\Entity\DoctrineBank;

#[ApiResource(
    shortName: 'Bank',
    stateOptions: new Options(entityClass: DoctrineBank::class),
    operations: [
        // getter

        new Get(
            name: '_api_/banking-bank/{id}',
            uriTemplate: '/banking-bank/{id}',
            provider: RootItemProvider::class,
            output: BankResource::class,
        ),

        new GetCollection(
            name: '_api_/banking-bank',
            uriTemplate: '/banking-bank',
            normalizationContext: ['iri_only' => true],
            itemUriTemplate: '/banking-bank/{id}',
            provider: RootCollectionProvider::class,
        ),
    ]
)]
final class BankResource
{
    #[ApiProperty(identifier: true, readable: false, writable: false)]
    public string $id;

    public ?string $name;
    public ?string $countrycode;
    public ?string $state;
    public ?\DateTimeImmutable $validityperiodsince;
    public ?\DateTimeImmutable $validityperioduntil;
    public ?string $url;
    public ?string $bic;
    public ?string $image;

    public static function mapEntityToDto(?DoctrineBank $doctrineEntity): ?self
    {
        if (null == $doctrineEntity) {
            return null;
        }

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
        $dto->name = $doctrineEntity->getname();
        $dto->countrycode = $doctrineEntity->getcountrycode();
        $dto->state = $doctrineEntity->getstate();
        $dto->validityperiodsince = $doctrineEntity->getvalidityperiodsince();
        $dto->validityperioduntil = $doctrineEntity->getvalidityperioduntil();
        $dto->url = $doctrineEntity->geturl();
        $dto->bic = $doctrineEntity->getbic();
        $dto->image = $doctrineEntity->getimage();

        return $dto;
    }
}
