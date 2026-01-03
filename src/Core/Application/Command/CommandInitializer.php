<?php

namespace Core\Application\Command;

class CommandInitializer
{
    private $command;

    function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * set property in input
     * 
     * set property of StdClass with value from command or from original object
     * in command property can be uninitialized, in this case original value is set
     * else command value is set
     * command value can be null, this is diffrent from uninitialized
     */
    public function set(string $property, mixed $original = null, ?string $valueObject = null): mixed
    {
        try {
            $this->command->$property;
            if ($valueObject) {
                return $this->command->$property ? new $valueObject($this->command->$property) : null;
            } else {
                return $this->command->$property;
            }
        } catch (\Throwable $th) {
            return $original;
        }
    }
    public function setId(string $property, mixed $original, ?object $foundedObject): mixed
    {
        try {
            $this->command->$property;
            return $foundedObject;
        } catch (\Throwable $th) {
            return $original;
        }
    }
    /**
     * copy the command into an initialized stdClass
     */
    public function getInitializedCopy(): object
    {
        $reflect = new \ReflectionClass($this->command);
        // $commandClassName = $reflect->getName();
        // /** @var object */
        // $copy = new $commandClassName();
        $copy = clone $this->command;
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $property = $prop->getName();
            try {
                $this->command->$property;
                $copy->$property = $this->command->$property;
            } catch (\Throwable $th) {
                $copy->$property = null;
            }
        }
        return $copy;
    }
}