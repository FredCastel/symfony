<?php

namespace Maker\Maker;

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;

class ApplicationMaker extends AbstractMaker
{
    public function __construct(
        private ApplicationCommandEntityGetterMaker $commandEntityGetterMaker,
        private ApplicationCommandAggregateGetterMaker $commandAggregateGetterMaker,
        private ApplicationCommandHandlerAbstractMaker $commandHandlerAbstractMaker,
        private ApplicationCommandHandlerMaker $commandHandlerMaker,
        private ApplicationCommandRequestMaker $commandRequestMaker,
        private ApplicationCommandVoterMaker $commandVoterMaker,
    ) {

    }

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'application';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create all command objects of a context');
    }

    static public function getNamespace(object $object): string
    {
        return '';

    }
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return '';

    }

    public function runGenerate(object $def, Generator $generator): void
    {
        echo "Generating Application Files...\n";
        
        $this->commandEntityGetterMaker->runGenerate($def, $generator);
        $this->commandAggregateGetterMaker->runGenerate($def, $generator);
        $this->commandRequestMaker->runGenerate($def, $generator);
        $this->commandVoterMaker->runGenerate($def, $generator);
        $this->commandHandlerAbstractMaker->runGenerate($def, $generator);
        $this->commandHandlerMaker->runGenerate($def, $generator);
    }
}