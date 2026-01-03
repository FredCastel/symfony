<?php

namespace Maker\Maker;

use Maker\Element\ApplicationElement;
use Maker\Element\CommandElement;
use Maker\Element\ResourceOperationElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Validator\Constraints\NotNull;

class ApiResourceOperationDtoMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'api_resource_operation_dto';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new infrastructure api resource dto class');
    }

    /**
     * Summary of getNamespace
     * @param ResourceOperationElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->resource->context->namespace->name . '\Infrastructure\ApiPlatform\Resource\\' . $object->resource->context->name . '\Dto';

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
            return $object->name . 'OperationDto';
    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Api Operation Dto...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource) {

                    foreach ($resource->operations as $operation) {

                            $useStatements = [];

                            $class_data = ClassData::create(
                                class: static::$generatedPath . self::getFullName($operation),
                                useStatements: [
                                    ...$useStatements,
                                    NotNull::class,
                                ]
                            );

                            //replace file; so delete existing
                            $this->deleteClassFile($class_data->getFullClassName());

                            $generator->generateClass(
                                className: $class_data->getFullClassName(),
                                templateName: MakerTemplate::getPath('ApiResourceOperationDto.php'),
                                variables: [
                                    'class_data' => $class_data,
                                    'ns' => self::getNamespace($operation),
                                    'makers' => $this->makers,
                                    'operation' => $operation,
                                ]
                            );

                            $generator->writeChanges();
                            self::$counter++;
                    }

                    // //operation
                    // foreach ($resource->operations as $operation) {

                    //     if ($operation->properties) {
                    //         $useStatements = [];

                    //         $class_data = ClassData::create(
                    //             class: static::$generatedPath . self::getFullName($operation),
                    //             useStatements: [
                    //                 ...$useStatements,
                    //                 NotNull::class,
                    //                 Length::class,
                    //             ]
                    //         );
                    //         $generator->generateClass(
                    //             $class_data->getFullClassName(),
                    //             __DIR__ . '/ApiResourceDto.tpl.php',
                    //             [
                    //                 'class_data' => $class_data,
                    //                 'ns' => self::getNamespace($operation),
                    //                 'operation' => $operation,
                    //                 'query' => null,
                    //             ]
                    //         );


                    //         $generator->writeChanges();
                    //         self::$counter++;
                    //     }
                    // }
                }
            }
        }
    }
}