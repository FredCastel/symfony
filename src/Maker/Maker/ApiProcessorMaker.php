<?php

namespace Maker\Maker;

use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Core\Infrastructure\ApiPlatform\State\Processor\CommandProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Maker\Element\CommandElement;
use Maker\Element\ResourceOperationElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Webmozart\Assert\Assert;

class ApiProcessorMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'api_processor';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new infrastructure api resource processor class');
    }

    /**
     * Summary of getNamespace
     * @param ResourceOperationElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->resource->context->namespace->name . '\Infrastructure\ApiPlatform\State\Processor\\' . $object->resource->context->name;

    }

    /**
     * Summary of getName
     * @param ResourceOperationElement $object
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return ucfirst($object->name) . $prefix . $suffix . 'Processor';
    }

    public function runGenerate(object $def, Generator $generator): void
    {
        echo "Generating Api Processor...\n";

        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource) {

                    foreach ($resource->operations as $operation) {

                        $useStatements = [];

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($operation),
                            extendsClass: CommandProcessor::class,
                            useStatements: [
                                ...$useStatements,
                                CommandProcessor::class,
                                Operation::class,
                                Assert::class,
                                ApplicationCommandRequestMaker::getFullName($operation->getTargetCommand()),
                                //ApiResourceDtoMaker::getFullName($resource),
                                ApiResourceMaker::getFullName($resource),
                            ]
                        );

                        //replace file; so delete existing
                        $this->deleteClassFile($class_data->getFullClassName());
                        
                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('ApiProcessor.php'),
                            variables: [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($operation),
                                'makers' => $this->makers,
                                'operation' => $operation,
                                'command' => $operation->getTargetCommand(),
                                'resource' => $operation->resource,
                            ]
                        );

                        $generator->writeChanges();
                        self::$counter++;

                    }
                }
            }
        }
    }
}