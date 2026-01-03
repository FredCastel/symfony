<?php

namespace Maker\Maker;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Maker\Element\ApplicationElement;
use Maker\Element\ResourceQueryElement;
use Maker\Element\TableElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ApiCollectionProviderMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'api_provider_collection';
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
     * Summary of getNamespace
     * @param ResourceQueryElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->resource->context->namespace->name . '\Infrastructure\ApiPlatform\State\Provider\\' . $object->resource->context->name;

    }

    /**
     * Summary of getName
     * @param ResourceQueryElement $object
     * @return string
     */
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return ($object->isRoot() ? 'Root' : $object->name) . $prefix . 'Collection' . $suffix . 'Provider';
    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Api Collection Provider...\n";

        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource) {

                    foreach ($resource->queries as $query) {
                        if (!$query->isCollectionQuery()) {
                            continue;
                        }

                        $useStatements = [];
                        foreach ($query->getSubResources() as $subResource) {
                            $useStatements[] = ApiResourceMaker::getFullName($subResource);
                        }

                        //collection
                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($query),
                            useStatements: [
                                ...$useStatements,
                                ApiResourceMaker::getFullName($resource),
                                ProviderInterface::class,
                                CollectionProvider::class,
                                ProviderInterface::class,
                                EntityManagerInterface::class,
                                Operation::class,
                                Autowire::class,
                                Paginator::class,
                                TraversablePaginator::class,
                            ]
                        );

                        //replace file; so delete existing
                        $this->deleteClassFile($class_data->getFullClassName());
                        
                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('ApiCollectionProvider.php'),
                            variables: [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($query),
                                'makers' => $this->makers,
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