<?php

namespace Tests\Banking\Application\Command\Bank;

use Banking\Application\Command\Bank\RegisterBank\RegisterBankHandler;
use Banking\Application\Command\Bank\RegisterBank\RegisterBankRequest;
use Banking\Domain\Aggregate\Bank\BankAggregate;
use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Banking\Domain\Event\Bank\BankRegisteredEvent;
use Banking\Domain\Repository\Bank\BankAggregateRepository;
use Banking\Domain\Repository\Bank\BankEntityRepository;
use Banking\Infrastructure\Doctrine\Repository\Bank\DoctrineBankAggregateRepository;
use Core\Infrastructure\InMemory\IntIdGenerator;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\Bus\Command\CommandBusMiddleware;
use Core\Service\Bus\Command\DispatcherCommandBus;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\Attributes\Group;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Banking\Infrastructure\InMemory\InMemoryBankAggregateRepository;

#[Group("application")]
#[Group("bank")]
#[Group("command")]
class BankCommandTest extends KernelTestCase
{
    private IntIdGenerator $idGenerator;
    private BankAggregateRepository $aggregateRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->idGenerator = new IntIdGenerator();
        $this->aggregateRepository = new InMemoryBankAggregateRepository();
        $this->getContainer()->set(BankAggregateRepository::class, $this->aggregateRepository);
    }

    public function test_bank_register(): void
    {
        //GIVEN
        $entityRepository = $this->createMock(BankEntityRepository::class);
        $entityRepository->expects($this->never())->method('get');

        $handler = new RegisterBankHandler(
            idGenerator: $this->idGenerator,
            bankAggregateRepository: $this->aggregateRepository,
            bankEntityRepository: $entityRepository,
        );
        //WHEN
        $id = $this->idGenerator->next();
        $command = new RegisterBankRequest(
            id: $id,
            entity_id: $id,
            name: 'test_bank_register',
            country: 'FR',
            bic:'error_bic'
        );
        $response = $handler->execute($command);

        //THEN
        $expectedEvent = new BankRegisteredEvent(
            id: $id,
            entity_id: $id,
            name: 'test_bank_register',
            country: 'FR',
            state: 'enabled',
            url: null,
            bic: 'error_bic',
            image: null,
            validSince: null,
            validUntil: null,
        );
        $this->assertIsObject($response);
        /** @var BankRegisteredEvent */
        $event = $response->events()[0];
        $this->assertInstanceOf(BankRegisteredEvent::class, $event);
        $this->assertEquals($expectedEvent,$event);
        $this->assertNotEquals('todo', $event->state);
        /** @var BankAggregate */
        $aggregate = $this->aggregateRepository->get($id);
        $this->assertEquals($id, $aggregate->getId()->value);
        $this->assertEquals(1, $aggregate->getVersion()->value);
        /** @var Bank */
        $bank = $aggregate->getRoot();
        $this->assertEquals($id, $bank->getId()->value);
        $this->assertEquals('test_bank_register', $bank->getName()->value);
        $this->assertEquals('FR', $bank->getCountry()->code);
        $this->assertEquals('enabled', $bank->getState()->value);
        $this->assertEquals( new \DateTimeImmutable('1990-01-01'), $bank->getValidityPeriod()->getSince()->value);
        $this->assertEquals( new \DateTimeImmutable('2099-12-31'), $bank->getValidityPeriod()->getUntil()->value);

    }

}