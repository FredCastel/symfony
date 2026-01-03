<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Bank;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Bank\DisableBank\DisableBankRequest;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\BankResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class DisableProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [DisableBankRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], BankResource::class);

        /** @var disableOperationDto */
        $input = $data;

        /** @var BankResource */
        $current = $context['previous_data'];
        $id = $current->id;

        $command = new DisableBankRequest(
            id: $id,
            entity_id: $input->entity_id,
        );

        $this->dispatch($command);
    }
}
