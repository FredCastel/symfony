<?php

namespace Core\Application\Message;

class SuccessMessage extends Message
{
    public function __construct(string $code, string $message, array $parameters = [])
    {
        parent::__construct(MessageCategory::Success, $code, $message, $parameters);

    }
}