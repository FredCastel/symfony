<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\_Tools\Getter;

use Banking\Domain\Aggregate\Account\Entity\Account;
use Banking\Domain\Repository\Account\AccountEntityRepository;
use Core\Application\Command\CommandNotFoundEntityException;
use Core\Application\Command\CommandRequiredEntityException;

trait AccountGetterTrait
{
    protected AccountEntityRepository $accountEntityRepository;
    protected iterable $accountDependencies = [];

    public function findAccountEntity(?string $id): ?Account
    {
        if (null == $id || '' == $id) {
            return null;
        }

        $entity = $this->accountEntityRepository->get($id);

        if (null == $entity) {
            throw new CommandNotFoundEntityException('Account entity does not exists');
        }

        return $entity;
    }

    public function requireAccountEntity(?string $id): Account
    {
        if (null == $id || '' == $id) {
            throw new CommandRequiredEntityException('Account is required');
        }

        return $this->FindAccountEntity($id);
    }

    public function isAccountUsed(?Account $entity): bool
    {
        if (null == $entity) {
            return false;
        }

        foreach ($this->accountDependencies as $dependency) {
            if ($dependency->usedAccount($entity)) {
                return true;
            }
        }

        return false;
    }
}
