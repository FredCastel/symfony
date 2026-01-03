<?php

namespace Core\Maker;

use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ApiQueryProviderMaker extends MyAbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'api_provider_item';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new infrastructure api resource provider class');
    }

    /**
     * Configure any library dependencies that your maker requires.
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {

    }

    /**
     * If necessary, you can use this method to interactively ask the user for input.
     */
    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {

    }

    static public function getNamespace(object $object): string
    {
        return $object->resource->context->namespace->name . '\Infrastructure\ApiPlatform\State\Provider\\' . $object->resource->context->name;

    }
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return $object->resource->name . $prefix . ucfirst($object->name) . $suffix . 'Provider';
    }

    public function runGenerate(object $def, Generator $generator): void
    {
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource) {

                    foreach ($resource->queries as $query) {

                        $useStatements = [];

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($query),
                            useStatements: [
                                ...$useStatements,
                                ApiResourceMaker::getFullName($query->resource),
                                ProviderInterface::class,
                                ItemProvider::class,
                                ProviderInterface::class,
                                EntityManagerInterface::class,
                                Operation::class,
                                Autowire::class,
                            ]
                        );
                        $generator->generateClass(
                            $class_data->getFullClassName(),
                            __DIR__ . '/ApiQueryProvider.tpl.php',
                            [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($query),
                                'query' => $query,
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