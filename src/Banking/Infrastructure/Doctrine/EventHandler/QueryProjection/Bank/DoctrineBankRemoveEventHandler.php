<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\EventHandler\QueryProjection\Bank;

use Banking\Domain\Event\Bank\BankRemovedEvent;
use Banking\Infrastructure\Doctrine\Mapper\DoctrineBankMapper;
use Banking\Infrastructure\Doctrine\Repository\Bank\DoctrineBankEntityRepository;
use Core\Infrastructure\Doctrine\EventHandler\AbstractPersistEventHandler;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineBankRemoveEventHandler extends AbstractPersistEventHandler
{
    public function __construct(
        DoctrineBankEntityRepository $repo,
        DoctrineBankMapper $mapper,
        EntityManagerInterface $em
    ) {
        parent::__construct($repo, $mapper, $em);
    }

    public function listenTo(): iterable
    {
        yield BankRemovedEvent::class;
    }
}
