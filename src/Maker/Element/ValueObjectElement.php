<?php

namespace Maker\Element;

class ValueObjectElement extends AbstractElement
{
    private readonly bool $core;

    public readonly ?string $extend;
    public readonly ?array $values;

    /**
     * Summary of inputs
     * @var ValueObjectInputElement[]
     */
    public array $inputs = [];

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
            $this->values = null;
        } else {
            $this->core = false;
            $this->extend = property_exists(object_or_class: $data, property: 'extend_ref') ? $data->extend_ref : null;

            if (property_exists(object_or_class: $data, property: 'values')) {
                $values=[];
                foreach ($data->values as $value) {
                    $values[] = $value->value;
                }
                $this->values =$values;
            }else {
                $this->values = null;
            }
        }

        //add inputs
        if (property_exists(object_or_class: $data, property: 'inputs')) {
            foreach ($data->inputs as $input_data) {
                new ValueObjectInputElement(valueObject: $this, data: $input_data);
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
        return $this->values !== null;
    }
}