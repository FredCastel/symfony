<?php

namespace Maker\Element;

class AggregateElement extends AbstractElement
{
    public readonly EntityElement $root;

    /**
     * Summary of commands
     * @var CommandElement[]
     */
    public array $commands = [];

    public function __construct(
        public readonly ContextElement $context,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;

        //set root entity
        $this->root = new EntityRootElement(aggregate: $this, data: $data->root);

        //add commands
        if (property_exists(object_or_class: $data, property: 'commands')) {
            foreach ($data->commands as $command_data) {
                new CommandElement(aggregate: $this, data: $command_data);
            }
        }

        $this->context->addAggregate($this);
    }

    //commands
    public function addCommand(CommandElement $command): self
    {
        $this->commands[$command->key] = $command;
        return $this;
    }
    public function getCommand(string $key): CommandElement
    {
        return $this->commands[$key];
    }

    //getter

    /**
     * Summary of getEntities
     * @return EntityElement[]
     */
    public function getEntities(): array
    {
        /** @var EntityElement[] */
        $list = [];
        $list = array_merge($list,[$this->root], $this->root->getChildEntities());
        return $list;
    }

    /**
     * Summary of getActions
     * @return ActionElement[]
     */
    public function getActions(): array
    {
        /** @var ActionElement[] */
        $list = [];
        foreach ($this->getEntities() as $entity) {
            $list = array_merge($list, $entity->actions);
        }
        return $list;
    }
}