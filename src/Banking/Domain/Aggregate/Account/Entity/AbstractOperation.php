<?php

namespace Banking\Domain\Aggregate\Account\Entity;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\Event\Account\OperationAddedEvent;
use Banking\Domain\Event\Account\OperationRemovedEvent;
use Banking\Domain\ValueObject\OperationCategory;
use Banking\Domain\ValueObject\OperationState;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\EntityChild;
use CORE\Domain\ValueObject\Amount;
use CORE\Domain\ValueObject\DateTime;
use CORE\Domain\ValueObject\Label;

/**
 * Account operation detail (items)* @generated This class is generated and updated by the maker, do not modify it manually.
 */
abstract class AbstractOperation extends EntityChild
{
    /**
     * Aggregate.
     *
     * @var AccountAggregate    */
    protected Aggregate $aggregate;

    /**
     * Parent Entity  An account, can be a cash or bank account.
     *
     * @var Account    */
    protected Entity $parent;

    /************* Entity Properties */

    protected Label $label;

    /**
     * account operation state.
     */
    protected OperationState $state;

    /**
     * account operation category.
     */
    protected OperationCategory $category;

    protected Amount $amount;

    protected DateTime $valueDate;

    protected DateTime $operationDate;

    /************* Entity Relations */

    /************* Children Entities */

    /************* Events Applier */

    /**
     * apply the event OperationAddedEvent on entity
     * related to action "AddOperation" : add a new operation in account
     * role insert.
     *
     * @see Banking\Domain\Event\Account\OperationAddedEvent
     *
     * @param OperationAddedEvent $event add a new operation in account
     */
    protected function applyOperationAdded(OperationAddedEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        // mapping parameters linked to an entity property
        $instance->label = new Label(
            value: $event->label,
        );

        $instance->amount = new Amount(
            value: $event->amount,
            currency: $instance->parent->getCurrency(),
        );

        $instance->valueDate = new DateTime(
            value: $event->valueDate,
        );

        $instance->operationDate = new DateTime(
            value: $event->operationDate,
        );

        return $instance;
    }

    /**
     * apply the event OperationRemovedEvent on entity
     * related to action "RemoveOperation" : remove an operation in account
     * role delete.
     *
     * @see Banking\Domain\Event\Account\OperationRemovedEvent
     *
     * @param OperationRemovedEvent $event remove an operation in account
     */
    protected function applyOperationRemoved(OperationRemovedEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        return $instance;
    }

    /************* Children Entities Events Applier */

    /************* Functionnal methods */

    /**
     * Set entity data from infra converter, like from a database mapper.
     *
     * @param OperationState    $state    account operation state
     * @param OperationCategory $category account operation category
     */
    public function set(
        Label $label,
        OperationState $state,
        OperationCategory $category,
        Amount $amount,
        DateTime $valueDate,
        DateTime $operationDate,
    ): self {
        $this->label = $label;
        $this->state = $state;
        $this->category = $category;
        $this->amount = $amount;
        $this->valueDate = $valueDate;
        $this->operationDate = $operationDate;

        return $this;
    }

    /**
     * check if the entity can be used / modify.
     */
    abstract public function isUsabled(): bool;

    // Is states getters

    /**
     * check if the entity is in the "ticked" state.
     */
    public function isTicked(): bool
    {
        return $this->state == OperationState::TICKED();
    }

    /**
     * check if the entity is in the "none" state.
     */
    public function isNone(): bool
    {
        return $this->state == OperationState::NONE();
    }

    /************* Voter */

    /**
     * check if the action "RemoveOperation" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Operation entity.
     */
    abstract public function canRemoveOperation(): bool;

    /************* Entity Properties Getter */

    /**
     * Get the Operation label property.
     */
    public function getLabel(): Label
    {
        return $this->label;
    }

    /**
     * Get the Operation state property
     * account operation state.
     */
    public function getState(): OperationState
    {
        return $this->state;
    }

    /**
     * Get the Operation category property
     * account operation category.
     */
    public function getCategory(): OperationCategory
    {
        return $this->category;
    }

    /**
     * Get the Operation amount property.
     */
    public function getAmount(): Amount
    {
        return $this->amount;
    }

    /**
     * Get the Operation valueDate property.
     */
    public function getValueDate(): DateTime
    {
        return $this->valueDate;
    }

    /**
     * Get the Operation operationDate property.
     */
    public function getOperationDate(): DateTime
    {
        return $this->operationDate;
    }

    /************* Entity Relations Getter */

    /************* Entity Child Entities Getter */

    /**
     * get sub entities of this entity.
     *
     * @return Entity[]
     */
    public function getChildEntities(): array
    {
        $children = [];

        return $children;
    }
}
