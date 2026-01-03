<?php

namespace Maker\Element;

abstract class AbstractElement
{
    protected static bool $lowerCaseName = false;
    public readonly string $key;
    public readonly string $name;
    public readonly ?string $description;
    public readonly bool $enabled;

    /** @var AbstractElement[] */
    private static $elements = [];

    public function __construct(
        \stdClass $data,
    ) {
        
        if (!property_exists(object_or_class: $data, property: 'key')) {
            throw new \InvalidArgumentException($data->name.' Element must have a key property');
        }  

        //add element to list
        static::$elements[$data->key] = $this;

        $this->key = $data->key;
        $this->name = static::$lowerCaseName ? lcfirst($data->name) : ucfirst($data->name);
        $this->description = property_exists(object_or_class: $data, property: 'description') ? $data->description : null;
        $this->enabled = property_exists(object_or_class: $data, property: 'enabled') ? $data->enabled : true;        
    }

    public static function get(string $ref): AbstractElement
    {
        if (!array_key_exists($ref, self::$elements)) {
            throw new \InvalidArgumentException('Element with ref '.$ref.' not found in '.static::class);
        }
        return self::$elements[$ref];

    }

}