<?php

namespace DataFixtures;

use Core\Application\Command\CommandRequest;

class FixtureCommand
{
    public string $id;
    public string $name;
    public string $requestClass;
    public string $method;
    public CommandRequest $request;
}

