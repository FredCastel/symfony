<?php

namespace Maker\Element;

class ValueObjectElement extends AbstractElement
{
    private readonly bool $core;

    public readonly ?string $extend;

    /**
     * Summary of inputs
     * @var ValueObjectInputElement[]
     */
    public array $inputs = [];

    /**
     * Summary of values
     * @var ValueObjectValueElement[]
     */
    public array $values = [];

    public function __construct(
        public readonly NamespaceElement $namespace,
        string|\stdClass $data,
    ) {
        if (!is_object($data)) {
            throw new \InvalidArgumentException($data.' is not a valid data object');
        }  
        parent::__construct(data: $data);

        if(!$this->enabled) return;

        if (gettype($data) == "string") {
            $this->core = true;
            $this->description = null;
            $this->extend = null;
        } else {
            $this->core = false;
            $this->extend = property_exists(object_or_class: $data, property: 'extend_ref') ? $data->extend_ref : null;
        }

        //add inputs
        if (property_exists(object_or_class: $data, property: 'inputs')) {
            foreach ($data->inputs as $input_data) {
                new ValueObjectInputElement(valueObject: $this, data: $input_data);
            }
        }

        //add values
        if (property_exists(object_or_class: $data, property: 'values')) {
            foreach ($data->values as $value_data) {
                new ValueObjectValueElement(valueObject: $this, data: $value_data);
            }
        }

        $this->namespace->addValueObject($this);
    }

    public static function getByName(string $name): ValueObjectElement
    {
        /** @var NamespaceElement */
        $core = NamespaceElement::get('core');
        foreach ($core->valueObjects as $valueObject) {
            if ($valueObject->name === $name) {
                return $valueObject;
            }
        }
        throw new \Exception("ValueObject '$name' not found in Core namespace.");
    }

    public function addInput(ValueObjectInputElement $input): self
    {
        $this->inputs[$input->key] = $input;
        return $this;
    }

    public function getInput(string $key): ValueObjectInputElement
    {
        return $this->inputs[$key];
    }

    public function addValue(ValueObjectValueElement $value): self
    {
        $this->values[$value->key] = $value;
        return $this;
    }

    public function getValue(string $key): ValueObjectValueElement
    {
        return $this->values[$key];
    }

    public function isCore(): bool
    {
        return $this->core;
    }
    public function isLocal(): bool
    {
        return !$this->isCore();
    }
    public function isCategory(): bool
    {
        return $this->extend === 'core>category';
    }
    public function isState(): bool
    {
        return $this->extend === 'core>state';
    }
    public function getExtended(): ValueObjectElement
    {
        return self::get($this->extend);
    }
    public function withValues(): bool
    {
        return !empty($this->values);
    }
}