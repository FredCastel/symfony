<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Banking\Infrastructure\ApiPlatform\State\Provider\Account\RootCollectionProvider;
use Banking\Infrastructure\ApiPlatform\State\Provider\Account\RootItemProvider;
use Banking\Infrastructure\Doctrine\Entity\DoctrineOperation;

#[ApiResource(
    shortName: 'Operation',
    stateOptions: new Options(entityClass: DoctrineOperation::class),
    operations: [
        // getter

        new Get(
            name: '_api_/banking-operation/{id}',
            uriTemplate: '/banking-operation/{id}',
            provider: RootItemProvider::class,
            output: OperationResource::class,
        ),

        new GetCollection(
            name: '_api_/banking-operation',
            uriTemplate: '/banking-operation',
            normalizationContext: ['iri_only' => true],
            itemUriTemplate: '/banking-operation/{id}',
            provider: RootCollectionProvider::class,
        ),
    ]
)]
final class OperationResource
{
    #[ApiProperty(identifier: true, readable: false, writable: false)]
    public string $id;

    public ?string $label;
    public ?string $state;
    public ?string $category;
    public ?float $amount;
    public ?\DateTimeImmutable $valuedate;
    public ?\DateTimeImmutable $operationdate;

    public ?AccountResource $account;

    public static function mapEntityToDto(?DoctrineOperation $doctrineEntity): ?self
    {
        if (null == $doctrineEntity) {
            return null;
        }

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
        $dto->label = $doctrineEntity->getlabel();
        $dto->state = $doctrineEntity->getstate();
        $dto->category = $doctrineEntity->getcategory();
        $dto->amount = $doctrineEntity->getamount();
        $dto->valuedate = $doctrineEntity->getvaluedate();
        $dto->operationdate = $doctrineEntity->getoperationdate();
        $dto->account = AccountResource::mapEntityToDto($doctrineEntity->getaccount());

        return $dto;
    }
}
