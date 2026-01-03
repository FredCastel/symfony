<?php

namespace Maker\Maker;

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;

class FullMaker extends AbstractMaker
{
    public function __construct(
        private DomainMaker $domainMaker,
        private ApplicationMaker $applicationMaker,
        private DoctrineMaker $doctrineMaker,
        private ApiMaker $apiMaker,
    ) {

    }

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'full';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create all objects');
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
        echo "Generating All Files...\n";

        $this->domainMaker->runGenerate($def, $generator);
        $this->applicationMaker->runGenerate($def, $generator);
        $this->doctrineMaker->runGenerate($def, $generator);
        $this->apiMaker->runGenerate($def, $generator);
    }
}