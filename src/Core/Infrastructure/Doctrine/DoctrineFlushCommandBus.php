<?php

namespace Core\Infrastructure\Doctrine;

use Core\Application\Command\CommandPresenter;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Doctrine\ORM\EntityManagerInterface;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\Bus\Command\CommandBusMiddleware;

class DoctrineFlushCommandBus implements CommandBusMiddleware
{

    public function __construct(
        private CommandBus $next,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function Dispatch(CommandRequest $command): CommandResponse
    {
        //$this->entityManager->getConnection()->setNestTransactionsWithSavepoints(true);//to remove warning : Nesting transactions without enabling savepoints is deprecated
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $response = $this->next->Dispatch($command);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Throwable $th) {
            $this->entityManager->getConnection()->rollBack();
            throw $th;
        }
        return $response;
    }
}