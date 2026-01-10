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
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\DisableOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\EnableOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\ListQueryDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\RegisterLegalOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\RegisterNaturalOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\RemoveOperationDto;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\RenameOperationDto;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\DisableProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\EnableProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\RegisterLegalProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\RegisterNaturalProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\RemoveProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Processor\Party\RenameProcessor;
use Cluster\Infrastructure\ApiPlatform\State\Provider\Party\ListCollectionProvider;
use Cluster\Infrastructure\Doctrine\Entity\DoctrineParty;
use Core\Infrastructure\ApiPlatform\State\Provider\ResourceCollectionProvider;
use Core\Infrastructure\ApiPlatform\State\Provider\ResourceItemProvider;

#[ApiResource(
    shortName: 'Party',
    stateOptions: new Options(entityClass: DoctrineParty::class),
    operations: [
        // getter
        new GetCollection(
            name: '_api_/cluster-party/list',
            uriTemplate: '/cluster-party/list',
            normalizationContext: ['iri_only' => false],
            itemUriTemplate: '/cluster-party/{id}',
            provider: ListCollectionProvider::class,
            output: ListQueryDto::class,
        ),

        // Resource Getters
        new GetCollection(
            name: '_api_/cluster-party',
            uriTemplate: '/cluster-party',
            normalizationContext: ['iri_only' => true],
            itemUriTemplate: '/cluster-party/{id}',
            provider: ResourceCollectionProvider::class,
        ),
        new Get(
            name: '_api_/cluster-party/{id}',
            uriTemplate: '/cluster-party/{id}',
            provider: ResourceItemProvider::class,
            output: PartyResource::class,
        ),
        // commands
        new Post(
            name: '_api_/cluster-party/registerNatural',
            uriTemplate: 'cluster-party/registerNatural',
            normalizationContext: ['iri_only' => true],
            provider: ResourceItemProvider::class,
            processor: RegisterNaturalProcessor::class,
            input: RegisterNaturalOperationDto::class,
        ),
        new Post(
            name: '_api_/cluster-party/registerLegal',
            uriTemplate: 'cluster-party/registerLegal',
            normalizationContext: ['iri_only' => true],
            provider: ResourceItemProvider::class,
            processor: RegisterLegalProcessor::class,
            input: RegisterLegalOperationDto::class,
        ),
        new Patch(
            name: '_api_/cluster-party/{id}/enable',
            uriTemplate: 'cluster-party/{id}/enable',
            provider: ResourceItemProvider::class,
            processor: EnableProcessor::class,
            input: EnableOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/cluster-party/{id}/disable',
            uriTemplate: 'cluster-party/{id}/disable',
            provider: ResourceItemProvider::class,
            processor: DisableProcessor::class,
            input: DisableOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/cluster-party/{id}/rename',
            uriTemplate: 'cluster-party/{id}/rename',
            provider: ResourceItemProvider::class,
            processor: RenameProcessor::class,
            input: RenameOperationDto::class,
            output: false,
        ),
        new Delete(
            name: '_api_/cluster-party/{id}/remove',
            uriTemplate: 'cluster-party/{id}/remove',
            provider: ResourceItemProvider::class,
            processor: RemoveProcessor::class,
            input: RemoveOperationDto::class,
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
        $dto->image = $doctrineEntity->getimage();

        return $dto;
    }
}
