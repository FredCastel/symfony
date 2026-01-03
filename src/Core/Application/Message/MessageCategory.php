<?php

namespace Core\Application\Message;

enum MessageCategory
{
    case Error;
    case Success;
    case Information;
    case Warning;
}