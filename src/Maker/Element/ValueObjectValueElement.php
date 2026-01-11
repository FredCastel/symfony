<?php

namespace Maker\Element;

class ValueObjectValueElement extends AbstractElement
{

    public readonly string $value;
    public readonly string $constantName;
    protected static bool $lowerCaseName = false;

    public function __construct(
        public readonly ValueObjectElement $valueObject,
        string|\stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;

        $this->value = $data->value;

        $this->valueObject->addValue($this);

        $this->constantName = strtoupper($this->value);
    }

}