<?php

namespace Banking\Infrastructure\ApiPlatform\State\Processor\Account;

use ApiPlatform\Metadata\Operation;
use Banking\Application\Command\Account\SetAccountBalanceLimits\SetAccountBalanceLimitsRequest;
use Banking\Infrastructure\ApiPlatform\Resource\Account\AccountResource;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Webmozart\Assert\Assert;

final class SetAccountBalanceLimitsProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [SetAccountBalanceLimitsRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($context['previous_data'], AccountResource::class);

        /** @var setAccountBalanceLimitsOperationDto */
        $input = $data;

        /** @var AccountResource */
        $current = $context['previous_data'];
        $id = $current->id;
        $entity_id = $current->id;

        $command = new SetAccountBalanceLimitsRequest(
            id: $id,
            entity_id: $entity_id,
            minimum: $input->minimum,
            maximum: $input->maximum,
        );

        $this->dispatch($command);
    }
}
