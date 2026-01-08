<?php

namespace DataFixtures\Banking;

use Banking\Application\Command\Bank\RegisterBank\RegisterBankRequest;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\IdGenerator;
use DataFixtures\FixtureObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\MakerBundle\FileManager;

class BankFixtures extends Fixture
{
    public function __construct(
        private CommandBus $commandBus,
        private IdGenerator $idGen,
    ) {}

    public function load(ObjectManager $manager): void
    {

        $file = 'fixtures/Banking/bank_fixtures.json';
        $def = json_decode(file_get_contents($file));

        /** @var FixtureObject[] */
        $fixtures = $def->fixtures;

        foreach ($fixtures as $fixture) {
            foreach ($fixture->commands as $commandData) {

                $aggragetId = $this->idGen->next();
                $entityId = $aggragetId;
                $requestClass = $commandData->requestClass;
                $request = new $requestClass(
                    id: $aggragetId,
                    entity_id: $entityId,
                    name: $commandData->request->name,
                    country: $commandData->request->country,
                    bic: $commandData->request->bic ?? null,
                );
                $this->commandBus->dispatch($request);
            }
        }
    }
}
