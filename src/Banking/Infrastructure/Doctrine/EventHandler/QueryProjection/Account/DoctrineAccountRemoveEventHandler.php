<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\EventHandler\QueryProjection\Account;

use Banking\Domain\Event\Account\AccountRemovedEvent;
use Banking\Infrastructure\Doctrine\Mapper\DoctrineAccountMapper;
use Banking\Infrastructure\Doctrine\Repository\Account\DoctrineAccountEntityRepository;
use Core\Infrastructure\Doctrine\EventHandler\AbstractPersistEventHandler;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineAccountRemoveEventHandler extends AbstractPersistEventHandler
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
        yield AccountRemovedEvent::class;
    }
}
