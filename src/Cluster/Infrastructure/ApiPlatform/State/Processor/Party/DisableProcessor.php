<?php

namespace Cluster\Infrastructure\ApiPlatform\State\Processor\Party;

use ApiPlatform\Metadata\Operation;
use Cluster\Application\Command\Party\Disable\DisableRequest;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\PartyResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class DisableProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [DisableRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], PartyResource::class);

        /** @var PartyResource */
        $current = $context['previous_data'];
        $id = $current->id;
        $entity_id = $current->id;

        $command = new DisableRequest(
            id: $id,
            entity_id: $entity_id,
        );

        $this->dispatch($command);
    }
}
