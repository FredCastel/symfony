<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\_Tools\Getter;

use Banking\Domain\Aggregate\Account\Entity\Operation;
use Banking\Domain\Repository\Account\OperationEntityRepository;
use Core\Application\Command\CommandNotFoundEntityException;
use Core\Application\Command\CommandRequiredEntityException;

trait OperationGetterTrait
{
    protected OperationEntityRepository $operationEntityRepository;
    protected iterable $operationDependencies = [];

    public function findOperationEntity(?string $id): ?Operation
    {
        if (null == $id || '' == $id) {
            return null;
        }

        $entity = $this->operationEntityRepository->get($id);

        if (null == $entity) {
            throw new CommandNotFoundEntityException('Operation entity does not exists');
        }

        return $entity;
    }

    public function requireOperationEntity(?string $id): Operation
    {
        if (null == $id || '' == $id) {
            throw new CommandRequiredEntityException('Operation is required');
        }

        return $this->FindOperationEntity($id);
    }

    public function isOperationUsed(?Operation $entity): bool
    {
        if (null == $entity) {
            return false;
        }

        foreach ($this->operationDependencies as $dependency) {
            if ($dependency->usedOperation($entity)) {
                return true;
            }
        }

        return false;
    }
}
