<?php

namespace Maker\Maker;

use Maker\Element\ApplicationElement;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;

class DomainMaker extends AbstractMaker
{
    public function __construct(
        private DomainEventMaker $domainEventMaker,
        private DomainValueObjectMaker $domainValueObjectMaker,
        private DomainAggregateMaker $domainAggregateMaker,
        private DomainEntityAbstractMaker $domainEntityAbstractMaker,
        private DomainEntityMaker $domainEntityMaker,
        private DomainDependencyMaker $domainDependencyMaker,
        private DomainAggregateRepositoryMaker $domainAggregateRepositoryMaker,
        private DomainEntityRepositoryMaker $domainEntityRepositoryMaker,
    ) {

    }

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'domain';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create all objects of a new domain for an aggregate');
    }

    static public function getNamespace(object $object): string
    {
        return '';

    }
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return '';

    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Domain...\n";
        
        $this->domainEventMaker->runGenerate($def, $generator);
        $this->domainValueObjectMaker->runGenerate($def, $generator);
        $this->domainAggregateMaker->runGenerate($def, $generator);
        $this->domainEntityAbstractMaker->runGenerate($def, $generator);
        $this->domainEntityMaker->runGenerate($def, $generator);
        $this->domainDependencyMaker->runGenerate($def, $generator);
        $this->domainAggregateRepositoryMaker->runGenerate($def, $generator);
        $this->domainEntityRepositoryMaker->runGenerate($def, $generator);
    }
}