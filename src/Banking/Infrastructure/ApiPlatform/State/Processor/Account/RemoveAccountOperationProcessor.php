<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Account;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Account\RemoveAccountOperation\RemoveAccountOperationRequest;
use Banking\Infrastructure\ApiPlatform\Resource\Account\OperationResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class RemoveAccountOperationProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [RemoveAccountOperationRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], OperationResource::class);

        /** @var OperationResource */
        $current = $context['previous_data'];
        $id = $current->id;
        $entity_id = $current->id;

        $command = new RemoveAccountOperationRequest(
            id: $id,
            entity_id: $entity_id,
        );

        $this->dispatch($command);
    }
}
