<?php

namespace Banking\Domain\Aggregate\Bank\Entity;

use Banking\Domain\Event\Bank\BankChangedEvent;
use Banking\Domain\Event\Bank\BankDisabledEvent;
use Banking\Domain\Event\Bank\BankEnabledEvent;
use Banking\Domain\Event\Bank\BankRegisteredEvent;
use Banking\Domain\Event\Bank\BankRemovedEvent;
use Banking\Domain\Event\Bank\BankRenamedEvent;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\EntityValidationException;

/**
 * * @todo apply necessary rules and changes
 */
final class Bank extends AbstractBank
{
    /************* Events Applier */

    public function applyBankRegisteredEvent(BankRegisteredEvent $event): self
    {
        $instance = parent::applyBankRegisteredEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyBankEnabledEvent(BankEnabledEvent $event): self
    {
        $instance = parent::applyBankEnabledEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyBankDisabledEvent(BankDisabledEvent $event): self
    {
        $instance = parent::applyBankDisabledEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyBankChangedEvent(BankChangedEvent $event): self
    {
        $instance = parent::applyBankChangedEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyBankRemovedEvent(BankRemovedEvent $event): self
    {
        $instance = parent::applyBankRemovedEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyBankRenamedEvent(BankRenamedEvent $event): self
    {
        $instance = parent::applyBankRenamedEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    /************* Children Entities Events Applier */

    /************* Functionnal methods */

    /**
     * check if the entity can be used / modify.
     */
    public function isUsabled(): bool
    {
        // TODO implement usage rules
        return true;
    }

    /************* Voter */

    /**
     * check if the action "Enable" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Bank entity.
     */
    public function canEnable(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Disable" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Bank entity.
     */
    public function canDisable(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Change" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Bank entity.
     */
    public function canChange(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Remove" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Bank entity.
     */
    public function canRemove(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Rename" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Bank entity.
     */
    public function canRename(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /************* Validator */

    /**
     * check concistency of the entity.
     *
     * @throws EntityValidationException
     */
    public function validate(): void
    {
        // TODO implement validation rules
    }
}
