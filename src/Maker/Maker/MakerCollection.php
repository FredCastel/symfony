<?php

namespace Maker\Maker;

class MakerCollection
{
    public function __construct(
        // ContainerInterface $container,
        public readonly DomainAggregateMaker $domainAggregateMaker,
        public readonly DomainEntityMaker $domainEntityMaker,
        public readonly DomainEntityAbstractMaker $domainEntityAbstractMaker,
        public readonly DomainEventMaker $domainEventMaker,
        public readonly DomainValueObjectMaker $domainValueObjectMaker,
        public readonly DomainDependencyMaker $domainDependencyMaker,
        public readonly DomainAggregateRepositoryMaker $domainAggregateRepositoryMaker,
        public readonly DomainEntityRepositoryMaker $domainEntityRepositoryMaker,

        public readonly ApplicationCommandRequestMaker $applicationCommandRequestMaker,
        public readonly ApplicationCommandEntityGetterMaker $applicationCommandEntityGetterMaker,
        public readonly ApplicationCommandAggregateGetterMaker $applicationCommandAggregateGetterMaker,
        
        public readonly DoctrineEntityMaker $doctrineEntityMaker,
        public readonly DoctrineAggregateRepositoryMaker $doctrineAggregateRepositoryMaker,
        public readonly DoctrineEntityRepositoryMaker $doctrineEntityRepositoryMaker,
        public readonly DoctrineMapperMaker $doctrineMapperMaker,
        public readonly DoctrineEventHandlerMaker $doctrineEventHandlerMaker,
        
        public readonly ApiResourceOperationDtoMaker $apiResourceOperationDtoMaker,
        public readonly ApiResourceQueryDtoMaker $apiResourceQueryDtoMaker,
        public readonly ApiItemProviderMaker $apiItemProviderMaker,
        public readonly ApiCollectionProviderMaker $apiCollectionProviderMaker,
        public readonly ApiResourceMaker $apiResourceMaker,
        public readonly ApiProcessorMaker $apiProcessorMaker,
    ) {
    }
}