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
        $entity_id = $this->idGen->next();
        $id = $entity_id;     // todo subentity manageement id

        $command = new AddAccountOperationRequest(
            id: $id,
            entity_id: $entity_id,
            operationDate: $input->operationDate,
            valueDate: $input->valueDate,
            amount: $input->amount,
            label: $input->label,
        );

        $this->dispatch($command);

        return $id;
    }
}
