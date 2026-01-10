<?php

namespace Cluster\Infrastructure\ApiPlatform\State\Processor\Party;

use ApiPlatform\Metadata\Operation;
use Cluster\Application\Command\Party\RegisterLegal\RegisterLegalRequest;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;

final class RegisterLegalProcessor extends CommandProcessor
{
    public static function usedCommandRequests(): array
    {
        return [RegisterLegalRequest::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var RegisterLegalOperationDto */
        $input = $data;
        $entity_id = $this->idGen->next();
        $id = $entity_id;     // todo subentity manageement id

        $command = new RegisterLegalRequest(
            id: $id,
            entity_id: $entity_id,
            name: $input->name,
            url: $input->url,
        );

        $this->dispatch($command);

        return $id;
    }
}
