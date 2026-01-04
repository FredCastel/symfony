<?php

namespace Cluster\Infrastructure\ApiPlatform\State\Processor\Party;

use ApiPlatform\Metadata\Operation;
use Cluster\Application\Command\Party\Rename\RenameRequest;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\PartyResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class RenameProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [RenameRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], PartyResource::class);

        /** @var RenameOperationDto */
        $input = $data;

        /** @var PartyResource */
        $current = $context['previous_data'];
        $id = $current->id;
        $entity_id = $current->id;

        $command = new RenameRequest(
            id: $id,
            entity_id: $entity_id,
            name: $input->name,
        );

        $this->dispatch($command);
    }
}
