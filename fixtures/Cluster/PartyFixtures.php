<?php

namespace DataFixtures\Cluster;

use Cluster\Application\Command\Party\RegisterNatural\RegisterNaturalRequest;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\IdGenerator;
use DataFixtures\FixtureObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PartyFixtures extends Fixture
{
    public function __construct(
        private CommandBus $commandBus,
        private IdGenerator $idGen,
    ) {}

    public function load(ObjectManager $manager): void
    {

        $file = 'fixtures/Cluster/party_fixtures.json';
        $def = json_decode(file_get_contents($file));

        /** @var FixtureObject[] */
        $fixtures = $def->fixtures;

        foreach ($fixtures as $fixture) {
            foreach ($fixture->commands as $command) {
                if ($command->method === 'post') {
                    $aggragetId = $this->idGen->next();
                    $entityId = $aggragetId;
                }

                switch ($command->requestClass) {
                    case RegisterNaturalRequest::class:
                        $request = new RegisterNaturalRequest(
                            id: $aggragetId,
                            entity_id: $entityId,
                            name: $command->request->name,
                        );
                        break;

                    default:
                    unset($request);
                        break;
                }
                $this->commandBus->dispatch($request);
            }
            
        }
    }
}
