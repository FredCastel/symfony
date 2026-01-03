<?php

namespace Cluster\Infrastructure\ApiPlatform\Resource\Party;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Cluster\Infrastructure\ApiPlatform\State\Provider\Party\RootCollectionProvider;
use Cluster\Infrastructure\ApiPlatform\State\Provider\Party\RootItemProvider;
use Cluster\Infrastructure\Doctrine\Entity\DoctrineParty;

#[ApiResource(
    shortName: 'Party',
    stateOptions: new Options(entityClass: DoctrineParty::class),
    operations: [
        // getter

        new Get(
            name: '_api_/cluster-party/{id}',
            uriTemplate: '/cluster-party/{id}',
            provider: RootItemProvider::class,
            output: PartyResource::class,
        ),

        new GetCollection(
            name: '_api_/cluster-party',
            uriTemplate: '/cluster-party',
            normalizationContext: ['iri_only' => true],
            itemUriTemplate: '/cluster-party/{id}',
            provider: RootCollectionProvider::class,
        ),
    ]
)]
final class PartyResource
{
    #[ApiProperty(identifier: true, readable: false, writable: false)]
    public string $id;

    public ?string $name;
    public ?string $state;
    public ?string $category;
    public ?\DateTimeImmutable $validityperiodsince;
    public ?\DateTimeImmutable $validityperioduntil;
    public ?string $url;
    public ?string $address;
    public ?string $image;

    public static function mapEntityToDto(?DoctrineParty $doctrineEntity): ?self
    {
        if (null == $doctrineEntity) {
            return null;
        }

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
        $dto->name = $doctrineEntity->getname();
        $dto->state = $doctrineEntity->getstate();
        $dto->category = $doctrineEntity->getcategory();
        $dto->validityperiodsince = $doctrineEntity->getvalidityperiodsince();
        $dto->validityperioduntil = $doctrineEntity->getvalidityperioduntil();
        $dto->url = $doctrineEntity->geturl();
        $dto->address = $doctrineEntity->getaddress();
        $dto->image = $doctrineEntity->getimage();

        return $dto;
    }
}
