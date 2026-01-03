<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\EventHandler\QueryProjection\Account;

use Banking\Domain\Event\Account\AccountBalanceLimitSetEvent;
use Banking\Domain\Event\Account\AccountChangedEvent;
use Banking\Domain\Event\Account\AccountClosedEvent;
use Banking\Domain\Event\Account\AccountInitialBalanceSetEvent;
use Banking\Domain\Event\Account\AccountOpenedEvent;
use Banking\Infrastructure\Doctrine\Mapper\DoctrineAccountMapper;
use Banking\Infrastructure\Doctrine\Repository\Account\DoctrineAccountEntityRepository;
use Core\Infrastructure\Doctrine\EventHandler\AbstractPersistEventHandler;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineAccountChangeEventHandler extends AbstractPersistEventHandler
{
    public function __construct(
        DoctrineAccountEntityRepository $repo,
        DoctrineAccountMapper $mapper,
        EntityManagerInterface $em
    ) {
        parent::__construct($repo, $mapper, $em);
    }

    public function listenTo(): iterable
    {
        yield AccountOpenedEvent::class;

        yield AccountClosedEvent::class;

        yield AccountChangedEvent::class;

        yield AccountInitialBalanceSetEvent::class;

        yield AccountBalanceLimitSetEvent::class;
    }
}
