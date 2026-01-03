<?php

namespace Cluster\Domain\Aggregate\Party\Entity;

use Cluster\Domain\Event\Party\PartyDisabledEvent;
use Cluster\Domain\Event\Party\PartyEnabledEvent;
use Cluster\Domain\Event\Party\PartyRegisteredEvent;
use Cluster\Domain\Event\Party\PartyRemovedEvent;
use Cluster\Domain\Event\Party\PartyRenamedEvent;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\EntityValidationException;

/**
 * legal or natural party* @todo apply necessary rules and changes
 */
final class Party extends AbstractParty
{
    /************* Events Applier */

    public function applyPartyRegistered(PartyRegisteredEvent $event): self
    {
        $instance = parent::applyPartyRegistered($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyPartyEnabled(PartyEnabledEvent $event): self
    {
        $instance = parent::applyPartyEnabled($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyPartyDisabled(PartyDisabledEvent $event): self
    {
        $instance = parent::applyPartyDisabled($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyPartyRenamed(PartyRenamedEvent $event): self
    {
        $instance = parent::applyPartyRenamed($event);

        // TODO manage custom rules when necessary

        return $instance;
    }

    public function applyPartyRemoved(PartyRemovedEvent $event): self
    {
        $instance = parent::applyPartyRemoved($event);

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
     * can be used to list the allowed action on an instance of the Party entity.
     */
    public function canEnable(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Disable" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Party entity.
     */
    public function canDisable(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Rename" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Party entity.
     */
    public function canRename(): bool
    {
        // TODO implement action voter rules
        return true;
    }

    /**
     * check if the action "Remove" can be applied on entity
     * this check is done before appling any the action
     * can be used to list the allowed action on an instance of the Party entity.
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
