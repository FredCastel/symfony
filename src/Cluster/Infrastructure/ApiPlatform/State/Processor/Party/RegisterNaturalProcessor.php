<?php

namespace Cluster\Infrastructure\ApiPlatform\State\Processor\Party;

use ApiPlatform\Metadata\Operation;
use Cluster\Application\Command\Party\RegisterNatural\RegisterNaturalRequest;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;

final class RegisterNaturalProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [RegisterNaturalRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var RegisterNaturalOperationDto */
        $input = $data;
        $entity_id = $this->idGen->next();
        $id = $entity_id;     // todo subentity manageement id

        $command = new RegisterNaturalRequest(
            id: $id,
            entity_id: $entity_id,
            name: $input->name,
            state: $input->state,
            category: $input->category,
        );

        $this->dispatch($command);

        return $id;
    }
}
