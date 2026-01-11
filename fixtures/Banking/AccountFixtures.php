<?php

namespace DataFixtures\Banking;

use Banking\Application\Command\Account\RegisterBankAccount\RegisterBankAccountRequest;
use Banking\Application\Command\Account\RegisterCashAccount\RegisterCashAccountRequest;
use Banking\Domain\ValueObject\AccountCategory;
use Banking\Infrastructure\Doctrine\Entity\DoctrineBank;
use Banking\Infrastructure\Doctrine\Repository\Account\DoctrineAccountEntityRepository;
use Cluster\Infrastructure\Doctrine\Entity\DoctrineParty;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\IdGenerator;
use DataFixtures\Cluster\PartyFixtures;
use DataFixtures\FixtureObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccountFixtures extends Fixture implements \Doctrine\Common\DataFixtures\DependentFixtureInterface
{
    public function __construct(
        private CommandBus $commandBus,
        private IdGenerator $idGen,
        private DoctrineAccountEntityRepository $repo,
    ) {}

    public function getDependencies(): array
    {
        return [
            BankFixtures::class,
            PartyFixtures::class,
        ];
    }
    
    public function load(ObjectManager $manager): void
    {

        $file = 'fixtures/Banking/account_fixtures.json';
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
                    case RegisterBankAccountRequest::class:
                        $party = $this->getReference($command->request->partyId, DoctrineParty::class);
                        $bank = $this->getReference($command->request->bankId, DoctrineBank::class);

                        $request = new RegisterBankAccountRequest(
                            id: $aggragetId,
                            entity_id: $entityId,
                            name: $command->request->name,
                            currency: $command->request->currency,
                            partyId: $party->getId()->__toString(),
                            bankId: $bank->getId()->__toString(),
                            category: AccountCategory::CB,
                        );
                        break;

                    case RegisterCashAccountRequest::class:
                        $request = new RegisterCashAccountRequest(
                            id: $aggragetId,
                            entity_id: $entityId,
                            name: $command->request->name,
                            currency: $command->request->currency,
                            partyId: $party->getId()->__toString(),
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
