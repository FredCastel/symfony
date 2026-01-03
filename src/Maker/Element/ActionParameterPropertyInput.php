<?php

namespace Maker\Element;

/**
 * An entity property input with action parameter
 */
class ActionParameterPropertyInput
{
    public function __construct(
    public EntityPropertyInputElement $input,
    public ?ActionParameterElement $parameter,
    ) {
    }
}