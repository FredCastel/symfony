<?php

namespace Cluster\Infrastructure\ApiPlatform\State\Processor\Party;

use ApiPlatform\Metadata\Operation;
use Cluster\Application\Command\Party\Remove\RemoveRequest;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\PartyResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class RemoveProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [RemoveRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], PartyResource::class);

        /** @var removeOperationDto */
        $input = $data;

        /** @var PartyResource */
        $current = $context['previous_data'];
        $id = $current->id;

        $command = new RemoveRequest(
            id: $id,
            entity_id: $input->entity_id,
        );

        $this->dispatch($command);
    }
}
