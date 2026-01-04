<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Bank;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Bank\SetBankBic\SetBankBicRequest;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\BankResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class SetBicProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [SetBankBicRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], BankResource::class);

        /** @var SetBicOperationDto */
        $input = $data;

        /** @var BankResource */
        $current = $context['previous_data'];
        $id = $current->id;
        $entity_id = $current->id;

        $command = new SetBankBicRequest(
            id: $id,
            entity_id: $entity_id,
            bic: $input->bic,
            name: $input->name,
            url: $input->url,
        );

        $this->dispatch($command);
    }
}
