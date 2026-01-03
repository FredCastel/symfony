<?php

namespace Maker\Element;

class EntityRootElement extends EntityElement
{
    public function isRoot(): bool
    {
        return true;
    }

    public function isChild(): bool
    {
        return false;
    }

}