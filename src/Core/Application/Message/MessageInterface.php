<?php

namespace Core\Application\Message;


interface MessageInterface
{

    public function __toString(): string;

    public function code(): string;

    public function parameters(): iterable;

    public function message(): ?string;
    public function category(): MessageCategory;
}