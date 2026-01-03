<?php

namespace Maker\Maker;

use ApiPlatform\Metadata\Get;
use Maker\Element\ApplicationElement;
use Maker\Element\ResourceQueryElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class ApiResourceQueryDtoMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'api_resource_query_dto';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new infrastructure api resource list dto class');
    }

    /**
     * Summary of getNamespace
     * @param ResourceQueryElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->resource->context->namespace->name . '\Infrastructure\ApiPlatform\Resource\\' . $object->resource->context->name . '\Dto';

    }
    
    /**
     * Summary of getName
     * @param ResourceQueryElement $object
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return $object->name . 'QueryDto';

    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Api Query Dto...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource) {

                    foreach ($resource->queries as $query) {
                        if ($query->isRoot())
                            continue;

                        $useStatements = [];
                        // foreach ($resource->associations as $association) {
                        //     $useStatements[] = ApiResourceMaker::getFullName($association->getTargetResource());
                        // }

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($query),
                            useStatements: [
                                ...$useStatements,
                                DoctrineEntityMaker::getFullName($resource),
                                Get::class,
                            ]
                        );

                        //replace file; so delete existing
                        $this->deleteClassFile($class_data->getFullClassName());

                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('ApiResourceQueryDto.php'),
                            variables: [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($query),
                                'makers' => $this->makers,
                                'resource' => $resource,
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