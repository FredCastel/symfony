<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Account;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Account\AddAccountOperation\AddAccountOperationRequest;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;

final class AddAccountOperationProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [AddAccountOperationRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var addAccountOperationOperationDto */
        $input = $data;
        $id = $this->idGen->next();

        $command = new AddAccountOperationRequest(
            id: $id,
            entity_id: $input->entity_id,
            operationDate: $input->operationDate,
            valueDate: $input->valueDate,
            amount: $input->amount,
            label: $input->label,
        );

        $this->dispatch($command);

        return $id;
    }
}
