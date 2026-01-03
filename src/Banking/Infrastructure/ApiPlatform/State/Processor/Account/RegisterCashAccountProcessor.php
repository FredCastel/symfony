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
        /** @var registerCashAccountOperationDto */
        $input = $data;
        $id = $this->idGen->next();

        $command = new RegisterCashAccountRequest(
            id: $id,
            entity_id: $input->entity_id,
            name: $input->name,
            currency: $input->currency,
            partyId: $input->partyId,
        );

        $this->dispatch($command);

        return $id;
    }
}
