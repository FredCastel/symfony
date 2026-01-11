<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Account;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Account\OpenAccount\OpenAccountRequest;
use Banking\Infrastructure\ApiPlatform\Resource\Account\AccountResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class OpenAccountProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [OpenAccountRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], AccountResource::class);

        /** @var AccountResource */
        $current = $context['previous_data'];
        $id = $current->id;
        $entity_id = $current->id;

        $command = new OpenAccountRequest(
            id: $id,
            entity_id: $entity_id,
        );

        $this->dispatch($command);
    }
}
