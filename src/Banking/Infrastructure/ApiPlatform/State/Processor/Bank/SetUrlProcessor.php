<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Bank;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Bank\SetBankUrl\SetBankUrlRequest;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\BankResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class SetUrlProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [SetBankUrlRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], BankResource::class);

        /** @var setUrlOperationDto */
        $input = $data;

        /** @var BankResource */
        $current = $context['previous_data'];
        $id = $current->id;

        $command = new SetBankUrlRequest(
            id: $id,
            entity_id: $input->entity_id,
            url: $input->url,
            name: $input->name,
            bic: $input->bic,
        );

        $this->dispatch($command);
    }
}
