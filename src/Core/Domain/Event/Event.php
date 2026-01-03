<?php

namespace Core\Domain\Event;

interface Event
{
    public function getId(): string;
}