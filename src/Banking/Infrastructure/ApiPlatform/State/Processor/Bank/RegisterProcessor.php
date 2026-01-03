<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Bank;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Bank\RegisterBank\RegisterBankRequest;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;

final class RegisterProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [RegisterBankRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var registerOperationDto */
        $input = $data;
        $id = $this->idGen->next();

        $command = new RegisterBankRequest(
            id: $id,
            entity_id: $input->entity_id,
            name: $input->name,
            country: $input->country,
            url: $input->url,
            bic: $input->bic,
        );

        $this->dispatch($command);

        return $id;
    }
}
