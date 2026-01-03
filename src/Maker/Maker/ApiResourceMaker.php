<?php

namespace Maker\Maker;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Core\Infrastructure\ApiPlatform\Payload\EmptyPayload;
use Core\Infrastructure\ApiPlatform\Resource\AllowedResource;
use Core\Infrastructure\ApiPlatform\State\Provider\AllowedOperationProvider;
use Maker\Element\ApplicationElement;
use Maker\Element\CommandElement;
use Maker\Element\EntityElement;
use Maker\Element\ResourceElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

class ApiResourceMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'api_resource';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new infrastructure api resource class');
    }

    /**
     * Summary of getNamespace
     * @param ResourceElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->context->namespace->name . '\Infrastructure\ApiPlatform\Resource\\' . $object->context->name;

    }

    /**
     * Summary of getName
     * @param ResourceElement $object
     * @return string
     */
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return $object->name . 'Resource';

    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Api Ressource...\n";

        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource) {
                    $entity = $resource->getTargetEntity();

                    $useStatements = [];
                    foreach ($resource->getSubResources() as $subResource) {
                        $useStatements[] = ApiResourceMaker::getFullName($subResource);
                    }
                    foreach ($resource->operations as $operation) {
                        $useStatements[] = ApiResourceOperationDtoMaker::getFullName($operation);
                        $useStatements[] = ApiProcessorMaker::getFullName($operation);
                    }
                    foreach ($resource->queries as $query) {
                        $useStatements[] = ApiResourceQueryDtoMaker::getFullName($query);
                        switch ($query->type) {
                            case 'item':
                                $useStatements[] = ApiItemProviderMaker::getFullName($query);
                                break;
                            case 'collection':
                                $useStatements[] = ApiCollectionProviderMaker::getFullName($query);
                                break;
                        }
                    }

                    $useStatements[] = DoctrineEntityMaker::getFullName($resource);

                    $class_data = ClassData::create(
                        class: static::$generatedPath . self::getFullName($resource),
                        useStatements: [
                            ...$useStatements,
                            ApiResource::class,
                            ApiFilter::class,
                            SearchFilter::class,
                            OrderFilter::class,
                            Link::class,
                            ApiProperty::class,
                            Options::class,
                            GetCollection::class,
                            Get::class,
                            Post::class,
                            Patch::class,
                            Delete::class,
                            EmptyPayload::class,
                            AllowedResource::class,
                            AllowedOperationProvider::class,
                        ]
                    );

                    //replace file; so delete existing
                    $this->deleteClassFile($class_data->getFullClassName());
                    
                    $generator->generateClass(
                        className: $class_data->getFullClassName(),
                        templateName: MakerTemplate::getPath('ApiResource.php'),
                        variables: [
                            'class_data' => $class_data,
                            'ns' => self::getNamespace($resource),
                            'makers' => $this->makers,
                            'resource' => $resource,
                            'entity' => $entity,
                        ]
                    );

                    $generator->writeChanges();
                    self::$counter++;
                }
            }
        }
    }
}