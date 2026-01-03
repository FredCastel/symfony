<?php

namespace Maker\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

class ApiMaker extends AbstractMaker
{
    public function __construct(
        private ApiResourceOperationDtoMaker $apiResourceOperationDtoMaker,
        private ApiResourceQueryDtoMaker $apiResourceQueryDtoMaker,
        private ApiItemProviderMaker $apiItemProviderMaker,
        private ApiCollectionProviderMaker $apiCollectionProviderMaker,
        private ApiProcessorMaker $apiProcessorMaker,
        private ApiResourceMaker $apiResourceMaker,
    ) {

    }

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'api';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create all api objects of a context');
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
        echo "Generating Api Files...\n";

        $this->apiResourceOperationDtoMaker->runGenerate($def, $generator);
        $this->apiResourceQueryDtoMaker->runGenerate($def, $generator);
        $this->apiItemProviderMaker->runGenerate($def, $generator);
        $this->apiCollectionProviderMaker->runGenerate($def, $generator);
        $this->apiProcessorMaker->runGenerate($def, $generator);
        $this->apiResourceMaker->runGenerate($def, $generator);
    }
}