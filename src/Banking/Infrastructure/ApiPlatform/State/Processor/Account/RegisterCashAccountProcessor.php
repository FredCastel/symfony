<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Account;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Account\RegisterCashAccount\RegisterCashAccountRequest;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;

final class RegisterCashAccountProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [RegisterCashAccountRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var RegisterCashAccountOperationDto */
        $input = $data;
        $entity_id = $this->idGen->next();
        $id = $entity_id;     // todo subentity manageement id

        $command = new RegisterCashAccountRequest(
            id: $id,
            entity_id: $entity_id,
            name: $input->name,
            currency: $input->currency,
            partyId: $input->partyId,
            category: $input->category,
            state: $input->state,
        );

        $this->dispatch($command);

        return $id;
    }
}
