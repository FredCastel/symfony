<?php

namespace Core\Domain\Aggregate;

use Core\Domain\Event\AbstractEvent;
use Core\Domain\ValueObject\Id;
use Core\Domain\ValueObject\Version;

abstract class Aggregate
{ 
    protected Version $version;
    protected EntityRoot $root;
    
    // /** @var EntityChild[] */
    // protected Array $entities = [];

    public function __construct(
        protected Id $id,
    ) {
        $this->version = new Version(0);
        $this->initRoot();
    }
    /**
     * aggregate must create it's root entity
     */
    abstract protected function initRoot(): void;

    public function apply(AbstractEvent $event): Aggregate{
        //call EntityRoot's apply method
        /**  @var Aggregate */
        $newVersionOfAggretate = $this->root->apply($event);

        //increment version after applying event
        $this->version = new Version($this->version->value + 1);

        return $newVersionOfAggretate;
    }

    /************* Getter & Setter ******************/

    public function getId(): Id
    {
        return $this->id;
    }
    public function getVersion(): Version
    {
        return $this->version;
    }

    abstract public function getRoot(): EntityRoot;
    /**
     * get all aggregate entities
     * 
     * used in get() method in entity repository
     * @return Entity[] array of entities with id as table key
     */
    abstract public function getEntities(): array;
}