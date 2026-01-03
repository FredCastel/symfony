<?php

namespace Core\Application\Message;


class ErrorMessage extends Message
{
    public function __construct(string $code, string $message, array $parameters = [])
    {
        parent::__construct(MessageCategory::Error, $code, $message, $parameters);

    }
}