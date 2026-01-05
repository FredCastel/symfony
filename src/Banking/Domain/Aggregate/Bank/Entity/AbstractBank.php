<?php

namespace Banking\Domain\Aggregate\Bank\Entity;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Banking\Domain\Event\Bank\BankChangedEvent;
use Banking\Domain\Event\Bank\BankDisabledEvent;
use Banking\Domain\Event\Bank\BankEnabledEvent;
use Banking\Domain\Event\Bank\BankRegisteredEvent;
use Banking\Domain\Event\Bank\BankRemovedEvent;
use Banking\Domain\ValueObject\BankState;
use Banking\Domain\ValueObject\Bic;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\EntityRoot;
use Core\Domain\ValueObject\Country;
use Core\Domain\ValueObject\Id;
use Core\Domain\ValueObject\Image;
use Core\Domain\ValueObject\Name;
use Core\Domain\ValueObject\Url;
use Core\Domain\ValueObject\ValidityPeriod;

/**
 * * @generated This class is generated and updated by the maker, do not modify it manually.
 */
abstract class AbstractBank extends EntityRoot
{
    /**
     * Aggregate.
     *
     * @var BankAggregate    */
    protected Aggregate $aggregate;

    /************* Entity Properties */

    /**
     * bank name.
     */
    protected Name $name;

    /**
     * bank country.
     */
    protected Country $country;

    /**
     * bank state.
     */
    protected BankState $state;

    protected ValidityPeriod $validityPeriod;

    protected ?Url $url;

    protected ?Bic $bic;

    protected ?Image $image;

    /************* Entity Relations */

    /************* Children Entities */

    /************* Events Applier */

    /**
     * apply the event BankRegisteredEvent on entity
     * related to action "Register" : Create a new bank
     * role insert.
     *
     * @see Banking\Domain\Event\Bank\BankRegisteredEvent
     *
     * @param BankRegisteredEvent $event Create a new bank
     */
    protected function applyBankRegisteredEvent(BankRegisteredEvent $event): self
    {
        // clone the existing instance, and apply changes
        // $instance = clone $this;

        // mapping parameters linked to an entity property
        $this->name = new Name(
            value: $event->name,
        );

        $this->state = new BankState(
            value: $event->state,
        );

        $this->country = new Country(
            code: $event->country,
        );

        $this->url = $event->url ? new Url(
            value: $event->url,
        ) : null;

        $this->bic = $event->bic ? new Bic(
            value: $event->bic,
        ) : null;

        $this->image = $event->image ? new Image(
            value: $event->image,
        ) : null;

        $this->validityPeriod = new ValidityPeriod(
            since: $event->validSince,
            until: null,
        );

        return $this;
    }

    /**
     * apply the event BankEnabledEvent on entity
     * related to action "Enable" : Change bank status to enabled
     * role update.
     *
     * @see Banking\Domain\Event\Bank\BankEnabledEvent
     *
     * @param BankEnabledEvent $event Change bank status to enabled
     */
    protected function applyBankEnabledEvent(BankEnabledEvent $event): self
    {
        // clone the existing instance, and apply changes
        // $instance = clone $this;

        return $this;
    }

    /**
     * apply the event BankDisabledEvent on entity
     * related to action "Disable" : Change bank status to disabled
     * role update.
     *
     * @see Banking\Domain\Event\Bank\BankDisabledEvent
     *
     * @param BankDisabledEvent $event Change bank status to disabled
     */
    protected function applyBankDisabledEvent(BankDisabledEvent $event): self
    {
        // clone the existing instance, and apply changes
        // $instance = clone $this;

        return $this;
    }

    /**
     * apply the event BankChangedEvent on entity
     * related to action "Change" : Change bank simple properties
     * role update.
     *
     * @see Banking\Domain\Event\Bank\BankChangedEvent
     *
     * @param BankChangedEvent $event Change bank simple properties
     */
    protected function applyBankChangedEvent(BankChangedEvent $event): self
    {
        // clone the existing instance, and apply changes
        // $instance = clone $this;

        // mapping parameters linked to an entity property
        $this->name = new Name(
            value: $event->name,
        );

        $this->url = $event->url ? new Url(
            value: $event->url,
        ) : null;

        $this->bic = $event->bic ? new Bic(
            value: $event->bic,
        ) : null;

        return $this;
    }

    /**
     * apply the event BankRemovedEvent on entity
     * related to action "Remove" : Delete a bank
     * role delete.
     *
     * @see Banking\Domain\Event\Bank\BankRemovedEvent
     *
     * @param BankRemovedEvent $event Delete a bank
     */
    protected function applyBankRemovedEvent(BankRemovedEvent $event): self
    {
        // clone the existing instance, and apply changes
        // $instance = clone $this;

        return $this;
    }

    /************* Children Entities Events Applier */

    /************* This Entity and child entities Action to Event function */

    /**
     * Create a new bank
     * Action : "Register"
     * Create the event : BankRegisteredEvent.
     *
     * @see Banking\Domain\Event\Bank\BankRegisteredEvent
     *
     * @param string      $entity_id  entity id
     * @param string      $name       bank name
     * @param string      $state      bank initial state
     * @param string      $country    bank country
     * @param string|null $url        url of the bank
     * @param string|null $bic        bic code of the bank
     * @param string|null $image      logo of the bank
     * @param string|null $validSince bank validity start date, can be null
     * @param string|null $validUntil bank validity end date, can be null
     */
    public function register(
        string $entity_id,
        string $name,
        string $state,
        string $country,
        ?string $url = null,
        ?string $bic = null,
        ?string $image = null,
        ?string $validSince = null,
        ?string $validUntil = null,
    ): array {
        $event = new BankRegisteredEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
            name: $name,
            state: $state,
            country: $country,
            url: $url,
            bic: $bic,
            image: $image,
            validSince: $validSince,
            validUntil: $validUntil,
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Change bank status to enabled
     * Action : "Enable"
     * Create the event : BankEnabledEvent.
     *
     * @see Banking\Domain\Event\Bank\BankEnabledEvent
     *
     * @param string $entity_id entity id
     */
    public function enable(
        string $entity_id,
    ): array {
        $event = new BankEnabledEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Change bank status to disabled
     * Action : "Disable"
     * Create the event : BankDisabledEvent.
     *
     * @see Banking\Domain\Event\Bank\BankDisabledEvent
     *
     * @param string $entity_id entity id
     */
    public function disable(
        string $entity_id,
    ): array {
        $event = new BankDisabledEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Change bank simple properties
     * Action : "Change"
     * Create the event : BankChangedEvent.
     *
     * @see Banking\Domain\Event\Bank\BankChangedEvent
     *
     * @param string      $entity_id entity id
     * @param string      $name      change bank name
     * @param string|null $url       change bank url
     * @param string|null $bic       change bank bic code
     */
    public function change(
        string $entity_id,
        string $name,
        ?string $url = null,
        ?string $bic = null,
    ): array {
        $event = new BankChangedEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
            name: $name,
            url: $url,
            bic: $bic,
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Delete a bank
     * Action : "Remove"
     * Create the event : BankRemovedEvent.
     *
     * @see Banking\Domain\Event\Bank\BankRemovedEvent
     *
     * @param string $entity_id entity id
     */
    public function remove(
        string $entity_id,
    ): array {
        $event = new BankRemovedEvent(
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
     * @param Name      $name    bank name
     * @param Country   $country bank country
     * @param BankState $state   bank state
     */
    public function set(
        Name $name,
        Country $country,
        BankState $state,
        ValidityPeriod $validityPeriod,
        ?Url $url,
        ?Bic $bic,
        ?Image $image,
    ): self {
        $this->name = $name;
        $this->country = $country;
        $this->state = $state;
        $this->validityPeriod = $validityPeriod;
        $this->url = $url;
        $this->bic = $bic;
        $this->image = $image;

        return $this;
    }

    /**
     * check if the entity can be used / modify.
     */
    abstract public function isUsabled(): bool;

    // Is states getters

    /**
     * check if the entity is in the "enabled" state.
     */
    public function isEnabled(): bool
    {
        return $this->state == BankState::ENABLED();
    }

    /**
     * check if the entity is in the "disabled" state.
     */
    public function isDisabled(): bool
    {
        return $this->state == BankState::DISABLED();
    }

    /************* Voter */

    /**
     * check if the action "Enable" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Bank entity.
     */
    abstract public function canEnable(): bool;

    /**
     * check if the action "Disable" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Bank entity.
     */
    abstract public function canDisable(): bool;

    /**
     * check if the action "Change" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Bank entity.
     */
    abstract public function canChange(): bool;

    /**
     * check if the action "Remove" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Bank entity.
     */
    abstract public function canRemove(): bool;

    /************* Entity Properties Getter */

    /**
     * Get the Bank name property
     * bank name.
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * Get the Bank country property
     * bank country.
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * Get the Bank state property
     * bank state.
     */
    public function getState(): BankState
    {
        return $this->state;
    }

    /**
     * Get the Bank validityPeriod property.
     */
    public function getValidityPeriod(): ValidityPeriod
    {
        return $this->validityPeriod;
    }

    /**
     * Get the Bank url property.
     */
    public function getUrl(): ?Url
    {
        return $this->url;
    }

    /**
     * Get the Bank bic property.
     */
    public function getBic(): ?Bic
    {
        return $this->bic;
    }

    /**
     * Get the Bank image property.
     */
    public function getImage(): ?Image
    {
        return $this->image;
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
