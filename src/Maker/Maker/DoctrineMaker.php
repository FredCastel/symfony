<?php

namespace Maker\Maker;

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;

class DoctrineMaker extends AbstractMaker
{
    public function __construct(
        private DoctrineEntityMaker $doctrineEntityMaker,
        private DoctrineAggregateRepositoryMaker $doctrineAggregateRepositoryMaker,
        private DoctrineEntityRepositoryMaker $doctrineEntityRepositoryMaker,
        private DoctrineMapperMaker $doctrineMapperMaker,
        private DoctrineEventHandlerMaker $doctrineEventHandlerMaker,
    ) {

    }

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'doctrine';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create all doctrine objects of a context');
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
        echo "Generating Doctrine files...\n";
        
        $this->doctrineEntityMaker->runGenerate($def, $generator);
        $this->doctrineAggregateRepositoryMaker->runGenerate($def, $generator);
        $this->doctrineEntityRepositoryMaker->runGenerate($def, $generator);
        $this->doctrineMapperMaker->runGenerate($def, $generator);
        $this->doctrineEventHandlerMaker->runGenerate($def, $generator);
    }
}