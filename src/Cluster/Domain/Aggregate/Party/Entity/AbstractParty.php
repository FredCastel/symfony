<?php

namespace Cluster\Domain\Aggregate\Party\Entity;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Cluster\Domain\Event\Party\PartyDisabledEvent;
use Cluster\Domain\Event\Party\PartyEnabledEvent;
use Cluster\Domain\Event\Party\PartyRegisteredEvent;
use Cluster\Domain\Event\Party\PartyRemovedEvent;
use Cluster\Domain\Event\Party\PartyRenamedEvent;
use Cluster\Domain\ValueObject\PartyCategory;
use Cluster\Domain\ValueObject\PartyState;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\EntityRoot;
use CORE\Domain\ValueObject\Address;
use CORE\Domain\ValueObject\Id;
use CORE\Domain\ValueObject\Image;
use CORE\Domain\ValueObject\Name;
use CORE\Domain\ValueObject\Url;
use CORE\Domain\ValueObject\ValidityPeriod;

/**
 * legal or natural party* @generated This class is generated and updated by the maker, do not modify it manually.
 */
abstract class AbstractParty extends EntityRoot
{
    /**
     * Aggregate.
     *
     * @var PartyAggregate    */
    protected Aggregate $aggregate;

    /************* Entity Properties */

    /**
     * Party Name.
     */
    protected Name $name;

    /**
     * Party State.
     */
    protected PartyState $state;

    /**
     * Party Category.
     */
    protected PartyCategory $category;

    /**
     * Party Validity dates.
     */
    protected ValidityPeriod $validityPeriod;

    protected ?Url $url;

    protected ?Address $address;

    protected ?Image $image;

    /************* Entity Relations */

    /************* Children Entities */

    /************* Events Applier */

    /**
     * apply the event PartyRegisteredEvent on entity
     * related to action "Register" : Register a new Party
     * role insert.
     *
     * @see Cluster\Domain\Event\Party\PartyRegisteredEvent
     *
     * @param PartyRegisteredEvent $event Register a new Party
     */
    protected function applyPartyRegisteredEvent(PartyRegisteredEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        // mapping parameters linked to an entity property
        $instance->name = new Name(
            value: $event->name,
        );

        $instance->state = new PartyState(
            value: $event->state,
        );

        $instance->category = new PartyCategory(
            value: $event->category,
        );

        $instance->url = $event->url ? new Url(
            value: $event->url,
        ) : null;

        $instance->address = $event->address ? new Address(
            value: $event->address,
        ) : null;

        $instance->image = $event->image ? new Image(
            value: $event->image,
        ) : null;

        return $instance;
    }

    /**
     * apply the event PartyEnabledEvent on entity
     * related to action "Enable" : Enable party
     * role update.
     *
     * @see Cluster\Domain\Event\Party\PartyEnabledEvent
     *
     * @param PartyEnabledEvent $event Enable party
     */
    protected function applyPartyEnabledEvent(PartyEnabledEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        return $instance;
    }

    /**
     * apply the event PartyDisabledEvent on entity
     * related to action "Disable" : Disable party
     * role update.
     *
     * @see Cluster\Domain\Event\Party\PartyDisabledEvent
     *
     * @param PartyDisabledEvent $event Disable party
     */
    protected function applyPartyDisabledEvent(PartyDisabledEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        return $instance;
    }

    /**
     * apply the event PartyRenamedEvent on entity
     * related to action "Rename" : Change name
     * role update.
     *
     * @see Cluster\Domain\Event\Party\PartyRenamedEvent
     *
     * @param PartyRenamedEvent $event Change name
     */
    protected function applyPartyRenamedEvent(PartyRenamedEvent $event): self
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
     * apply the event PartyRemovedEvent on entity
     * related to action "Remove" : Remove Party
     * role delete.
     *
     * @see Cluster\Domain\Event\Party\PartyRemovedEvent
     *
     * @param PartyRemovedEvent $event Remove Party
     */
    protected function applyPartyRemovedEvent(PartyRemovedEvent $event): self
    {
        // clone the existing instance, and apply changes
        $instance = clone $this;

        return $instance;
    }

    /************* Children Entities Events Applier */

    /************* This Entity and child entities Action to Event function */

    /**
     * Register a new Party
     * Action : "Register"
     * Create the event : PartyRegisteredEvent.
     *
     * @see Cluster\Domain\Event\Party\PartyRegisteredEvent
     *
     * @param string      $entity_id entity id
     * @param string      $name      Party Name
     * @param string      $state     Party State
     * @param string      $category  Party Category
     * @param string|null $url       Party url
     * @param string|null $address   Party Address
     * @param string|null $image     Party Picture
     */
    public function register(
        string $entity_id,
        string $name,
        string $state,
        string $category,
        ?string $url = null,
        ?string $address = null,
        ?string $image = null,
    ): array {
        $event = new PartyRegisteredEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
            name: $name,
            state: $state,
            category: $category,
            url: $url,
            address: $address,
            image: $image,
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Enable party
     * Action : "Enable"
     * Create the event : PartyEnabledEvent.
     *
     * @see Cluster\Domain\Event\Party\PartyEnabledEvent
     *
     * @param string $entity_id entity id
     */
    public function enable(
        string $entity_id,
    ): array {
        $event = new PartyEnabledEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Disable party
     * Action : "Disable"
     * Create the event : PartyDisabledEvent.
     *
     * @see Cluster\Domain\Event\Party\PartyDisabledEvent
     *
     * @param string $entity_id entity id
     */
    public function disable(
        string $entity_id,
    ): array {
        $event = new PartyDisabledEvent(
            id: $this->aggregate->getId(),// aggregate Id,
            entity_id: $entity_id,// entity Id
        );

        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }

    /**
     * Change name
     * Action : "Rename"
     * Create the event : PartyRenamedEvent.
     *
     * @see Cluster\Domain\Event\Party\PartyRenamedEvent
     *
     * @param string $entity_id entity id
     * @param string $name      Party Name
     */
    public function rename(
        string $entity_id,
        string $name,
    ): array {
        $event = new PartyRenamedEvent(
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
     * Remove Party
     * Action : "Remove"
     * Create the event : PartyRemovedEvent.
     *
     * @see Cluster\Domain\Event\Party\PartyRemovedEvent
     *
     * @param string $entity_id entity id
     */
    public function remove(
        string $entity_id,
    ): array {
        $event = new PartyRemovedEvent(
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
     * @param Name           $name           party Name
     * @param PartyState     $state          party State
     * @param PartyCategory  $category       party Category
     * @param ValidityPeriod $validityPeriod party Validity dates
     */
    public function set(
        Name $name,
        PartyState $state,
        PartyCategory $category,
        ValidityPeriod $validityPeriod,
        ?Url $url,
        ?Address $address,
        ?Image $image,
    ): self {
        $this->name = $name;
        $this->state = $state;
        $this->category = $category;
        $this->validityPeriod = $validityPeriod;
        $this->url = $url;
        $this->address = $address;
        $this->image = $image;

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
        return $this->state == PartyState::DRAFT();
    }

    /**
     * check if the entity is in the "enabled" state.
     */
    public function isEnabled(): bool
    {
        return $this->state == PartyState::ENABLED();
    }

    /**
     * check if the entity is in the "disabled" state.
     */
    public function isDisabled(): bool
    {
        return $this->state == PartyState::DISABLED();
    }

    /************* Voter */

    /**
     * check if the action "Enable" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Party entity.
     */
    abstract public function canEnable(): bool;

    /**
     * check if the action "Disable" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Party entity.
     */
    abstract public function canDisable(): bool;

    /**
     * check if the action "Rename" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Party entity.
     */
    abstract public function canRename(): bool;

    /**
     * check if the action "Remove" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Party entity.
     */
    abstract public function canRemove(): bool;

    /************* Entity Properties Getter */

    /**
     * Get the Party name property
     * Party Name.
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * Get the Party state property
     * Party State.
     */
    public function getState(): PartyState
    {
        return $this->state;
    }

    /**
     * Get the Party category property
     * Party Category.
     */
    public function getCategory(): PartyCategory
    {
        return $this->category;
    }

    /**
     * Get the Party validityPeriod property
     * Party Validity dates.
     */
    public function getValidityPeriod(): ValidityPeriod
    {
        return $this->validityPeriod;
    }

    /**
     * Get the Party url property.
     */
    public function getUrl(): ?Url
    {
        return $this->url;
    }

    /**
     * Get the Party address property.
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * Get the Party image property.
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
