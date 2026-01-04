<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Bank;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Bank\EnableBank\EnableBankRequest;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\BankResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class EnableProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [EnableBankRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], BankResource::class);

        /** @var BankResource */
        $current = $context['previous_data'];
        $id = $current->id;
        $entity_id = $current->id;

        $command = new EnableBankRequest(
            id: $id,
            entity_id: $entity_id,
        );

        $this->dispatch($command);
    }
}
