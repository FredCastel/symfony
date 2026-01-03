<?php

namespace Core\Application\Message;


class InformationMessage extends Message
{
    public function __construct(string $code, string $message, array $parameters = [])
    {
        parent::__construct(MessageCategory::Information, $code, $message, $parameters);

    }
}