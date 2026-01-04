<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto\DisableOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto\EnableOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto\RegisterOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto\RemoveOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto\RenameOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto\SetBicOperationDto;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto\SetUrlOperationDto;
use Banking\Infrastructure\ApiPlatform\State\Processor\Bank\DisableProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Bank\EnableProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Bank\RegisterProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Bank\RemoveProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Bank\RenameProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Bank\SetBicProcessor;
use Banking\Infrastructure\ApiPlatform\State\Processor\Bank\SetUrlProcessor;
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

        // commands
        new Post(
            name: '_api_/banking-bank/register',
            uriTemplate: 'banking-bank/register',
            normalizationContext: ['iri_only' => true],
            provider: RootItemProvider::class,
            processor: RegisterProcessor::class,
            input: RegisterOperationDto::class,
        ),
        new Patch(
            name: '_api_/banking-bank/{id}/enable',
            uriTemplate: 'banking-bank/{id}/enable',
            provider: RootItemProvider::class,
            processor: EnableProcessor::class,
            input: EnableOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-bank/{id}/disable',
            uriTemplate: 'banking-bank/{id}/disable',
            provider: RootItemProvider::class,
            processor: DisableProcessor::class,
            input: DisableOperationDto::class,
            output: false,
        ),
        new Delete(
            name: '_api_/banking-bank/{id}/remove',
            uriTemplate: 'banking-bank/{id}/remove',
            provider: RootItemProvider::class,
            processor: RemoveProcessor::class,
            input: RemoveOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-bank/{id}/rename',
            uriTemplate: 'banking-bank/{id}/rename',
            provider: RootItemProvider::class,
            processor: RenameProcessor::class,
            input: RenameOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-bank/{id}/setUrl',
            uriTemplate: 'banking-bank/{id}/setUrl',
            provider: RootItemProvider::class,
            processor: SetUrlProcessor::class,
            input: SetUrlOperationDto::class,
            output: false,
        ),
        new Patch(
            name: '_api_/banking-bank/{id}/setBic',
            uriTemplate: 'banking-bank/{id}/setBic',
            provider: RootItemProvider::class,
            processor: SetBicProcessor::class,
            input: SetBicOperationDto::class,
            output: false,
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
