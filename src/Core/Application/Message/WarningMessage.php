<?php

namespace Core\Application\Message;

class WarningMessage extends Message
{
    public function __construct(string $code, string $message, array $parameters = [])
    {
        parent::__construct(MessageCategory::Warning, $code, $message, $parameters);

    }
}