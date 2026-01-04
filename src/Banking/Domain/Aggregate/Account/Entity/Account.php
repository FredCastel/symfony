<?php

namespace Banking\Domain\Aggregate\Account\Entity;

use Banking\Domain\Event\Account\AccountBalanceLimitSetEvent;
use Banking\Domain\Event\Account\AccountChangedEvent;
use Banking\Domain\Event\Account\AccountClosedEvent;
use Banking\Domain\Event\Account\AccountInitialBalanceSetEvent;
use Banking\Domain\Event\Account\AccountOpenedEvent;
use Banking\Domain\Event\Account\AccountRegisteredEvent;
use Banking\Domain\Event\Account\AccountRemovedEvent;
use Banking\Domain\Event\Account\OperationAddedEvent;
use Banking\Domain\Event\Account\OperationRemovedEvent;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\EntityValidationException;

/**
 * An account, can be a cash or bank account* @todo apply necessary rules and changes
 */
final class Account extends AbstractAccount
{
    /************* Events Applier */

    public function applyAccountRegisteredEvent(AccountRegisteredEvent $event): self
    {
        $instance = parent::applyAccountRegisteredEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyAccountOpenedEvent(AccountOpenedEvent $event): self
    {
        $instance = parent::applyAccountOpenedEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyAccountClosedEvent(AccountClosedEvent $event): self
    {
        $instance = parent::applyAccountClosedEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyAccountChangedEvent(AccountChangedEvent $event): self
    {
        $instance = parent::applyAccountChangedEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyAccountInitialBalanceSetEvent(AccountInitialBalanceSetEvent $event): self
    {
        $instance = parent::applyAccountInitialBalanceSetEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyAccountBalanceLimitSetEvent(AccountBalanceLimitSetEvent $event): self
    {
        $instance = parent::applyAccountBalanceLimitSetEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyAccountRemovedEvent(AccountRemovedEvent $event): self
    {
        $instance = parent::applyAccountRemovedEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    /************* Children Entities Events Applier */

    public function applyOperationAddedEvent(OperationAddedEvent $event): self
    {
        $instance = parent::applyOperationAddedEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyOperationRemovedEvent(OperationRemovedEvent $event): self
    {
        $instance = parent::applyOperationRemovedEvent($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

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
     * check if the action "Open" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    public function canOpen(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Close" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    public function canClose(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Change" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    public function canChange(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "SetInitialBalance" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    public function canSetInitialBalance(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "SetBalanceLimits" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    public function canSetBalanceLimits(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Remove" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    public function canRemove(): bool
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
