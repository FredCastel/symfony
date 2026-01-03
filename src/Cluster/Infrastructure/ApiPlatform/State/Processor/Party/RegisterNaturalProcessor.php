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
        /** @var registerNaturalOperationDto */
        $input = $data;
        $id = $this->idGen->next();

        $command = new RegisterNaturalRequest(
            id: $id,
            entity_id: $input->entity_id,
            name: $input->name,
            address: $input->address,
        );

        $this->dispatch($command);

        return $id;
    }
}
