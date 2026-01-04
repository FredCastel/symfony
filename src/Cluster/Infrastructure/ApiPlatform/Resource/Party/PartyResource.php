<?php

namespace Cluster\Infrastructure\ApiPlatform\Resource\Party;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\disableOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\enableOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\registerLegalOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\registerNaturalOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\removeOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\renameOperationDto;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\disableProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\enableProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\registerLegalProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\registerNaturalProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\removeProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\renameProcessor;
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

        // commands
        new Post(
            name: '_api_/cluster-party/registerNatural',
            uriTemplate: 'cluster-party/registerNatural',
            normalizationContext: ['iri_only' => true],
            provider: RootItemProvider::class,
            processor: registerNaturalProcessor::class,
            input: registerNaturalOperationDto::class,
        ),
        new Post(
            name: '_api_/cluster-party/registerLegal',
            uriTemplate: 'cluster-party/registerLegal',
            normalizationContext: ['iri_only' => true],
            provider: RootItemProvider::class,
            processor: registerLegalProcessor::class,
            input: registerLegalOperationDto::class,
        ),
        new Patch(
            name: '_api_/cluster-party/{id}/enable',
            uriTemplate: 'cluster-party/{id}/enable',
            provider: RootItemProvider::class,
            processor: enableProcessor::class,
            input: enableOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/cluster-party/{id}/disable',
            uriTemplate: 'cluster-party/{id}/disable',
            provider: RootItemProvider::class,
            processor: disableProcessor::class,
            input: disableOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/cluster-party/{id}/rename',
            uriTemplate: 'cluster-party/{id}/rename',
            provider: RootItemProvider::class,
            processor: renameProcessor::class,
            input: renameOperationDto::class,
            output: false,
        ),
        new Delete(
            name: '_api_/cluster-party/{id}/remove',
            uriTemplate: 'cluster-party/{id}/remove',
            provider: RootItemProvider::class,
            processor: removeProcessor::class,
            input: removeOperationDto::class,
            output: false,
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
