<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\_Tools\Getter;

use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Banking\Domain\Repository\Bank\BankEntityRepository;
use Core\Application\Command\CommandNotFoundEntityException;
use Core\Application\Command\CommandRequiredEntityException;

trait BankGetterTrait
{
    protected BankEntityRepository $bankEntityRepository;
    protected iterable $bankDependencies = [];

    public function findBankEntity(?string $id): ?Bank
    {
        if (null == $id || '' == $id) {
            return null;
        }

        $entity = $this->bankEntityRepository->get($id);

        if (null == $entity) {
            throw new CommandNotFoundEntityException('Bank entity does not exists');
        }

        return $entity;
    }

    public function requireBankEntity(?string $id): Bank
    {
        if (null == $id || '' == $id) {
            throw new CommandRequiredEntityException('Bank is required');
        }

        return $this->FindBankEntity($id);
    }

    public function isBankUsed(?Bank $entity): bool
    {
        if (null == $entity) {
            return false;
        }

        foreach ($this->bankDependencies as $dependency) {
            if ($dependency->usedBank($entity)) {
                return true;
            }
        }

        return false;
    }
}
