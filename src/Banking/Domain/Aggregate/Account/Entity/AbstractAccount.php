<?php

namespace Banking\Domain\Aggregate\Account\Entity;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\Event\Account\AccountBalanceLimitSetEvent;
use Banking\Domain\Event\Account\AccountChangedEvent;
use Banking\Domain\Event\Account\AccountClosedEvent;
use Banking\Domain\Event\Account\AccountInitialBalanceSetEvent;
use Banking\Domain\Event\Account\AccountOpenedEvent;
use Banking\Domain\Event\Account\AccountRegisteredEvent;
use Banking\Domain\Event\Account\AccountRemovedEvent;
use Banking\Domain\Event\Account\OperationAddedEvent;
use Banking\Domain\Event\Account\OperationRemovedEvent;
use Banking\Domain\ValueObject\AccountCategory;
use Banking\Domain\ValueObject\AccountState;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\EntityRoot;
use Core\Domain\ValueObject\Amount;
use Core\Domain\ValueObject\Currency;
use Core\Domain\ValueObject\Id;
use Core\Domain\ValueObject\Name;
use Core\Domain\ValueObject\ValidityPeriod;

/**
 * An account, can be a cash or bank account* @generated This class is generated and updated by the maker, do not modify it manually.
 */
abstract class AbstractAccount extends EntityRoot
{
    /**
     * Aggregate.
     *
     * @var AccountAggregate    */
    protected Aggregate $aggregate;

    /************* Entity Properties */

    /**
     * the account name.
     */
    protected Name $name;

    /**
     * the state of the accoun (draft, opened, closed).
     */
    protected AccountState $state;

    /**
     * the account category (bank account or cash account).
     */
    protected AccountCategory $category;

    /**
     * currency code.
     */
    protected Currency $currency;

    /**
     * the actual amount of the account.
     */
    protected Amount $balance;

    /**
     * the balance of the account before adding any operation.
     */
    protected ?Amount $initialBalance;

    /**
     * the minimum balance allowed in the account.
     */
    protected ?Amount $minimumBalance;

    /**
     * the maximum balance allowed in the account.
     */
    protected ?Amount $maximumBalance;

    /**
     * the start and the end date of validity.
     */
    protected ValidityPeriod $validityPeriod;

    /************* Entity Relations */

    /**
     * the related bank id in case of bank account.
     */
    protected ?Id $bankId;

    /**
     * relation to Party.
     */
    protected Id $partyId;

    /************* Children Entities */

    /** @var Operation[] */
    protected array $operations = [];

    /************* Events Applier */

    /**
     * apply the event AccountRegisteredEvent on entity
     * related to action "Register" : Create a new account
     * role insert.
     *
     * @see Banking\Domain\Event\Account\AccountRegisteredEvent
     *
     * @param AccountRegisteredEvent $event Create a new account
     */
    protected function applyAccountRegisteredEvent(AccountRegisteredEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        // mapping parameters linked to an entity property
        $instance->name = new Name(
            value: $event->name,
        );

        $instance->state = new AccountState(
            value: $event->state,
        );

        $instance->category = new AccountCategory(
            value: $event->category,
        );

        $instance->currency = new Currency(
            code: $event->currency,
        );

        $instance->validityPeriod = new ValidityPeriod(
            since: $event->validSince,
            until: $event->validUntil,
        );

        // mapping parameters linked to an entity relation (external entity key)
        $instance->bankId = $event->bankId ? new Id($event->bankId) : null;
        $instance->partyId = new Id($event->partyId);

        return $instance;
    }

    /**
     * apply the event AccountOpenedEvent on entity
     * related to action "Open" : Change account state to opened
     * role update.
     *
     * @see Banking\Domain\Event\Account\AccountOpenedEvent
     *
     * @param AccountOpenedEvent $event Change account state to opened
     */
    protected function applyAccountOpenedEvent(AccountOpenedEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        return $instance;
    }

    /**
     * apply the event AccountClosedEvent on entity
     * related to action "Close" : Change account state to closed
     * role update.
     *
     * @see Banking\Domain\Event\Account\AccountClosedEvent
     *
     * @param AccountClosedEvent $event Change account state to closed
     */
    protected function applyAccountClosedEvent(AccountClosedEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        return $instance;
    }

    /**
     * apply the event AccountChangedEvent on entity
     * related to action "Change" : Change account simple properties
     * role update.
     *
     * @see Banking\Domain\Event\Account\AccountChangedEvent
     *
     * @param AccountChangedEvent $event Change account simple properties
     */
    protected function applyAccountChangedEvent(AccountChangedEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        // mapping parameters linked to an entity property
        $instance->name = new Name(
            value: $event->name,
        );

        return $instance;
    }

    /**
     * apply the event AccountInitialBalanceSetEvent on entity
     * related to action "SetInitialBalance" : Set initial account balance when account is in draft status
     * role update.
     *
     * @see Banking\Domain\Event\Account\AccountInitialBalanceSetEvent
     *
     * @param AccountInitialBalanceSetEvent $event Set initial account balance when account is in draft status
     */
    protected function applyAccountInitialBalanceSetEvent(AccountInitialBalanceSetEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        // mapping parameters linked to an entity property
        $instance->initialBalance = new Amount(
            value: $event->balance,
            currency: $instance->getCurrency(),
        );

        return $instance;
    }

    /**
     * apply the event AccountBalanceLimitSetEvent on entity
     * related to action "SetBalanceLimits" : Set min and max balance amount
     * role update.
     *
     * @see Banking\Domain\Event\Account\AccountBalanceLimitSetEvent
     *
     * @param AccountBalanceLimitSetEvent $event Set min and max balance amount
     */
    protected function applyAccountBalanceLimitSetEvent(AccountBalanceLimitSetEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        // mapping parameters linked to an entity property
        $instance->minimumBalance = new Amount(
            value: $event->minimum,
            currency: $instance->getCurrency(),
        );

        $instance->maximumBalance = new Amount(
            value: $event->maximum,
            currency: $instance->getCurrency(),
        );

        return $instance;
    }

    /**
     * apply the event AccountRemovedEvent on entity
     * related to action "Remove" : remove a closed account
     * role delete.
     *
     * @see Banking\Domain\Event\Account\AccountRemovedEvent
     *
     * @param AccountRemovedEvent $event remove a closed account
     */
    protected function applyAccountRemovedEvent(AccountRemovedEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        return $instance;
    }

    /************* Children Entities Events Applier */

    /**
     * apply the event OperationAddedEvent on this entity has parent
     * related to action "AddOperation" : add a new operation in account  of child entity Operation    * role insert.
     *
     * @see Banking\Domain\Event\Account\OperationAddedEvent
     *
     * @param OperationAddedEvent $event add a new operation in account
     */
    protected function applyOperationAddedEvent(OperationAddedEvent $event): self
    {
        // this is a change action, clone the existing instance, and apply changes
        $instance = clone $this;

        // create new child entity
        $child = new Operation(id: new Id($event->entity_id), aggregate: $this->aggregate, parent: $this);
        // apply event on child entity
        $child = $child->apply($event);
        // add child to collection
        $instance->operations[$child->getId()->value] = $child;

        return $instance;
    }

    /**
     * apply the event OperationRemovedEvent on this entity has parent
     * related to action "RemoveOperation" : remove an operation in account  of child entity Operation    * role delete.
     *
     * @see Banking\Domain\Event\Account\OperationRemovedEvent
     *
     * @param OperationRemovedEvent $event remove an operation in account
     */
    protected function applyOperationRemovedEvent(OperationRemovedEvent $event): self
    {
        // this is a change action, clone the existing instance, and apply changes
        $instance = clone $this;

        // get child entity from collection
        $child = $instance->getOperation(new Id($event->entity_id));
        // apply event on child entity
        $child = $child->apply($event);
        // remove child from collection
        unset($instance->operations[$child->getId()->value]);

        return $instance;
    }

    /************* This Entity and child entities Action to Event function */

    /**
     * Create a new account
     * Action : "Register"
     * Create the event : AccountRegisteredEvent.
     *
     * @see Banking\Domain\Event\Account\AccountRegisteredEvent
     *
     * @param string      $entity_id  entity id
     * @param string      $name       account name
     * @param string      $state      account initial state
     * @param string      $category   account category
     * @param string      $currency   account currency
     * @param string|null $validSince account validity start date, can be null
     * @param string|null $validUntil account validity end date, can be null
     * @param string|null $bankId     id of the related bank
     * @param string      $partyId    relation to Party
     */
    public function register(
        string $entity_id,
        string $name,
        string $state,
        string $category,
        string $currency,
        ?string $validSince = null,
        ?string $validUntil = null,
        ?string $bankId = null,
        string $partyId,
    ): array {
        $event = new AccountRegisteredEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
            name: $name,
            state: $state,
            category: $category,
            currency: $currency,
            validSince: $validSince,
            validUntil: $validUntil,
            bankId: $bankId,
            partyId: $partyId,
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Change account state to opened
     * Action : "Open"
     * Create the event : AccountOpenedEvent.
     *
     * @see Banking\Domain\Event\Account\AccountOpenedEvent
     *
     * @param string $entity_id entity id
     */
    public function open(
        string $entity_id,
    ): array {
        $event = new AccountOpenedEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Change account state to closed
     * Action : "Close"
     * Create the event : AccountClosedEvent.
     *
     * @see Banking\Domain\Event\Account\AccountClosedEvent
     *
     * @param string $entity_id entity id
     */
    public function close(
        string $entity_id,
    ): array {
        $event = new AccountClosedEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Change account simple properties
     * Action : "Change"
     * Create the event : AccountChangedEvent.
     *
     * @see Banking\Domain\Event\Account\AccountChangedEvent
     *
     * @param string $entity_id entity id
     * @param string $name      change account name
     */
    public function change(
        string $entity_id,
        string $name,
    ): array {
        $event = new AccountChangedEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
            name: $name,
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Set initial account balance when account is in draft status
     * Action : "SetInitialBalance"
     * Create the event : AccountInitialBalanceSetEvent.
     *
     * @see Banking\Domain\Event\Account\AccountInitialBalanceSetEvent
     *
     * @param string $entity_id entity id
     * @param float  $balance   set account initial balance
     */
    public function setInitialBalance(
        string $entity_id,
        float $balance,
    ): array {
        $event = new AccountInitialBalanceSetEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
            balance: $balance,
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Set min and max balance amount
     * Action : "SetBalanceLimits"
     * Create the event : AccountBalanceLimitSetEvent.
     *
     * @see Banking\Domain\Event\Account\AccountBalanceLimitSetEvent
     *
     * @param string $entity_id entity id
     * @param float  $minimum   set account min balance allowed
     * @param float  $maximum   set account max balance allowed
     */
    public function setBalanceLimits(
        string $entity_id,
        float $minimum,
        float $maximum,
    ): array {
        $event = new AccountBalanceLimitSetEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
            minimum: $minimum,
            maximum: $maximum,
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * remove a closed account
     * Action : "Remove"
     * Create the event : AccountRemovedEvent.
     *
     * @see Banking\Domain\Event\Account\AccountRemovedEvent
     *
     * @param string $entity_id entity id
     */
    public function remove(
        string $entity_id,
    ): array {
        $event = new AccountRemovedEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * add a new operation in account
     * Action : "AddOperation"
     * Create the event : OperationAddedEvent.
     *
     * @see Banking\Domain\Event\Account\OperationAddedEvent
     *
     * @param string $entity_id entity id
     * @param string $label     set operation label
     */
    public function addOperation(
        string $entity_id,
        string $label,
        float $amount,
        string $valueDate,
        string $operationDate,
    ): array {
        $event = new OperationAddedEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
            label: $label,
            amount: $amount,
            valueDate: $valueDate,
            operationDate: $operationDate,
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * remove an operation in account
     * Action : "RemoveOperation"
     * Create the event : OperationRemovedEvent.
     *
     * @see Banking\Domain\Event\Account\OperationRemovedEvent
     *
     * @param string $entity_id entity id
     */
    public function removeOperation(
        string $entity_id,
    ): array {
        $event = new OperationRemovedEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /************* Functionnal methods */

    /**
     * Set entity data from infra converter, like from a database mapper.
     *
     * @param Name            $name           the account name
     * @param AccountState    $state          the state of the accoun (draft, opened, closed)
     * @param AccountCategory $category       the account category (bank account or cash account)
     * @param Currency        $currency       currency code
     * @param Amount          $balance        the actual amount of the account
     * @param Amount|null     $initialBalance the balance of the account before adding any operation
     * @param Amount|null     $minimumBalance the minimum balance allowed in the account
     * @param Amount|null     $maximumBalance the maximum balance allowed in the account
     * @param ValidityPeriod  $validityPeriod the start and the end date of validity
     * @param Id|null         $bankId         the related bank id in case of bank account
     * @param Id              $partyId        relation to Party
     */
    public function set(
        Name $name,
        AccountState $state,
        AccountCategory $category,
        Currency $currency,
        Amount $balance,
        ?Amount $initialBalance,
        ?Amount $minimumBalance,
        ?Amount $maximumBalance,
        ValidityPeriod $validityPeriod,
        ?Id $bankId,
        Id $partyId,
    ): self {
        $this->name = $name;
        $this->state = $state;
        $this->category = $category;
        $this->currency = $currency;
        $this->balance = $balance;
        $this->initialBalance = $initialBalance;
        $this->minimumBalance = $minimumBalance;
        $this->maximumBalance = $maximumBalance;
        $this->validityPeriod = $validityPeriod;
        $this->bankId = $bankId;
        $this->partyId = $partyId;

        return $this;
    }

    /**
     * check if the entity can be used / modify.
     */
    abstract public function isUsabled(): bool;

    // Is states getters

    /**
     * check if the entity is in the "draft" state.
     */
    public function isDraft(): bool
    {
        return $this->state == AccountState::DRAFT();
    }

    /**
     * check if the entity is in the "opened" state.
     */
    public function isOpened(): bool
    {
        return $this->state == AccountState::OPENED();
    }

    /**
     * check if the entity is in the "closed" state.
     */
    public function isClosed(): bool
    {
        return $this->state == AccountState::CLOSED();
    }

    /************* Voter */

    /**
     * check if the action "Open" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    abstract public function canOpen(): bool;

    /**
     * check if the action "Close" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    abstract public function canClose(): bool;

    /**
     * check if the action "Change" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    abstract public function canChange(): bool;

    /**
     * check if the action "SetInitialBalance" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    abstract public function canSetInitialBalance(): bool;

    /**
     * check if the action "SetBalanceLimits" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    abstract public function canSetBalanceLimits(): bool;

    /**
     * check if the action "Remove" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Account entity.
     */
    abstract public function canRemove(): bool;

    /************* Entity Properties Getter */

    /**
     * Get the Account name property
     * the account name.
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * Get the Account state property
     * the state of the accoun (draft, opened, closed).
     */
    public function getState(): AccountState
    {
        return $this->state;
    }

    /**
     * Get the Account category property
     * the account category (bank account or cash account).
     */
    public function getCategory(): AccountCategory
    {
        return $this->category;
    }

    /**
     * Get the Account currency property
     * currency code.
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * Get the Account balance property
     * the actual amount of the account.
     */
    public function getBalance(): Amount
    {
        return $this->balance;
    }

    /**
     * Get the Account initialBalance property
     * the balance of the account before adding any operation.
     */
    public function getInitialBalance(): ?Amount
    {
        return $this->initialBalance;
    }

    /**
     * Get the Account minimumBalance property
     * the minimum balance allowed in the account.
     */
    public function getMinimumBalance(): ?Amount
    {
        return $this->minimumBalance;
    }

    /**
     * Get the Account maximumBalance property
     * the maximum balance allowed in the account.
     */
    public function getMaximumBalance(): ?Amount
    {
        return $this->maximumBalance;
    }

    /**
     * Get the Account validityPeriod property
     * the start and the end date of validity.
     */
    public function getValidityPeriod(): ValidityPeriod
    {
        return $this->validityPeriod;
    }

    /************* Entity Relations Getter */

    /**
     * Get the Account bankId property/relation
     * the related bank id in case of bank account.
     */
    public function getBankId(): ?Id
    {
        return $this->bankId;
    }

    /**
     * Get the Account partyId property/relation
     * relation to Party.
     */
    public function getPartyId(): Id
    {
        return $this->partyId;
    }

    /************* Entity Child Entities Getter */

    /**
     * get sub entities of this entity.
     *
     * @return Entity[]
     */
    public function getChildEntities(): array
    {
        $children = [];

        foreach ($this->operations as $childEntity) {
            $children[] = $childEntity;
        }

        return $children;
    }

    /**
     * get all operations.
     *
     * @return Operation[]
     */
    public function getOperations(): array
    {
        return $this->operations;
    }

    /**
     * get an Operation by it's id.
     */
    public function getOperation(Id $id): Operation
    {
        return $this->operations[$id->value];
    }
}
