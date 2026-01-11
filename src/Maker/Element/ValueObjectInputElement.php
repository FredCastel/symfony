<?php

namespace Maker\Element;

class ValueObjectInputElement extends AbstractElement
{

    public readonly ?string $type;
    protected readonly string $initialValue;
    private readonly ?string $target_value_object_ref;
    protected static bool $lowerCaseName = true;

    public function __construct(
        public readonly ValueObjectElement $valueObject,
        string|\stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;

        $this->type = property_exists(object_or_class: $data, property: 'type') ? $data->type : null;
        $this->initialValue = property_exists(object_or_class: $data, property: 'initialValue') ? $data->initialValue : 'null';
        $this->target_value_object_ref = property_exists(object_or_class: $data, property: 'target_value_object_ref') ? $data->target_value_object_ref : null;

        $this->valueObject->addInput($this);
    }

    public function linkedToValueObject(): bool
    {
        return $this->target_value_object_ref !== null;
    }

    public function getTargetValueObject(): ValueObjectElement
    {
        return self::get($this->target_value_object_ref);
    }

    public function getInitialValue(): string
    {
        if ($this->linkedToValueObject()) {
            return 'null';
        }
        return $this->initialValue ?? 'null';
    }
}