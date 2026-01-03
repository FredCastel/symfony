<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Account;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Account\RegisterBankAccount\RegisterBankAccountRequest;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;

final class RegisterBankAccountProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [RegisterBankAccountRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var registerBankAccountOperationDto */
        $input = $data;
        $id = $this->idGen->next();

        $command = new RegisterBankAccountRequest(
            id: $id,
            entity_id: $input->entity_id,
            name: $input->name,
            currency: $input->currency,
            partyId: $input->partyId,
            bankId: $input->bankId,
        );

        $this->dispatch($command);

        return $id;
    }
}
