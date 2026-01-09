<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\EventHandler\QueryProjection\Bank;

use Banking\Domain\Event\Bank\BankChangedEvent;
use Banking\Domain\Event\Bank\BankDisabledEvent;
use Banking\Domain\Event\Bank\BankEnabledEvent;
use Banking\Infrastructure\Doctrine\Mapper\DoctrineBankMapper;
use Banking\Infrastructure\Doctrine\Repository\Bank\DoctrineBankAggregateRepository;
use Banking\Infrastructure\Doctrine\Repository\Bank\DoctrineBankEntityRepository;
use Core\Infrastructure\Doctrine\EventHandler\AbstractUpdateEventHandler;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineBankChangeEventHandler extends AbstractUpdateEventHandler
{
    public function __construct(
        DoctrineBankAggregateRepository $aggregateRepository,
        DoctrineBankEntityRepository $repo,
        DoctrineBankMapper $mapper,
        EntityManagerInterface $em
    ) {
        parent::__construct($aggregateRepository, $repo, $mapper, $em);
    }

    public function listenTo(): iterable
    {
        yield BankEnabledEvent::class;

        yield BankDisabledEvent::class;

        yield BankChangedEvent::class;
    }
}
