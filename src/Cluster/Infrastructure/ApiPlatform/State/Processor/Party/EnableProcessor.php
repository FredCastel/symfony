<?php

namespace Cluster\Infrastructure\ApiPlatform\State\Processor\Party;

use ApiPlatform\Metadata\Operation;
use Cluster\Application\Command\Party\Enable\EnableRequest;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\PartyResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class EnableProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [EnableRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], PartyResource::class);

        /** @var PartyResource */
        $current = $context['previous_data'];
        $id = $current->id;
        $entity_id = $current->id;

        $command = new EnableRequest(
            id: $id,
            entity_id: $entity_id,
        );

        $this->dispatch($command);
    }
}
