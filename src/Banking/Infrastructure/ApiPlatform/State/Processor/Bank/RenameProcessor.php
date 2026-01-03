<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Bank;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Bank\RenameBank\RenameBankRequest;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\BankResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class RenameProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [RenameBankRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], BankResource::class);

        /** @var renameOperationDto */
        $input = $data;

        /** @var BankResource */
        $current = $context['previous_data'];
        $id = $current->id;

        $command = new RenameBankRequest(
            id: $id,
            entity_id: $input->entity_id,
            name: $input->name,
            url: $input->url,
            bic: $input->bic,
        );

        $this->dispatch($command);
    }
}
