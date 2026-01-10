<?php

namespace DataFixtures\Banking;

use Banking\Application\Command\Bank\RegisterBank\RegisterBankRequest;
use Banking\Application\Command\Bank\RemoveBank\RemoveBankRequest;
use Banking\Application\Command\Bank\SetBankUrl\SetBankUrlRequest;
use Banking\Infrastructure\Doctrine\Repository\Bank\DoctrineBankEntityRepository;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\IdGenerator;
use DataFixtures\FixtureObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BankFixtures extends Fixture
{
    public function __construct(
        private CommandBus $commandBus,
        private IdGenerator $idGen,
        private DoctrineBankEntityRepository $repo,
    ) {}

    public function load(ObjectManager $manager): void
    {

        $file = 'fixtures/Banking/bank_fixtures.json';
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
                    case RegisterBankRequest::class:
                        $request = new RegisterBankRequest(
                            id: $aggragetId,
                            entity_id: $entityId,
                            name: $command->request->name,
                            country: $command->request->country,
                            bic: $command->request->bic ?? null,
                        );
                        break;

                    case SetBankUrlRequest::class:
                        $request = new SetBankUrlRequest(
                            id: $aggragetId,
                            entity_id: $entityId,
                            url: $command->request->url,
                        );
                        break;

                    case RemoveBankRequest::class:
                        $request = new RemoveBankRequest(
                            id: $aggragetId,
                            entity_id: $entityId,
                        );
                        break;


                    default:
                    unset($request);
                        break;
                }

                $this->commandBus->dispatch($request);
                
                if ($command->method === 'post') {
                    //save ref
                    $entity = $this->repo->find($entityId);
                    $this->addReference($command->key, $entity);
                }
            }
            
        }
    }
}
