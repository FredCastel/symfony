<?php

namespace Banking\Domain\Aggregate\Account\Entity;

use Banking\Domain\Event\Account\OperationAddedEvent;
use Banking\Domain\Event\Account\OperationRemovedEvent;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\EntityValidationException;

/**
 * Account operation detail (items)* @todo apply necessary rules and changes
 */
final class Operation extends AbstractOperation
{
    /************* Events Applier */

    public function applyOperationAdded(OperationAddedEvent $event): self
    {
        $instance = parent::applyOperationAdded($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyOperationRemoved(OperationRemovedEvent $event): self
    {
        $instance = parent::applyOperationRemoved($event);

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
     * check if the action "RemoveOperation" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Operation entity.
     */
    public function canRemoveOperation(): bool
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
