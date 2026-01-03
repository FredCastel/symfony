<?php

namespace Maker\Maker;

use Core\Application\Command\CommandNotFoundEntityException;
use Core\Application\Command\CommandRequiredEntityException;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class ApplicationCommandEntityGetterMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'command_getter_entity';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new command entity getter trait');
    }

    /**
     * Summary of getNamespace
     * @param EntityElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->aggregate->context->namespace->name . '\Application\Command\\' . $object->aggregate->context->name . '\_Tools\Getter';

    }
    /**
     * Summary of getName
     * @param EntityElement $object
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return ucfirst($object->name) . 'GetterTrait';

    }

    public function runGenerate(object $def, Generator $generator): void
    {
        echo "Generating Application Command Entity Getters...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->aggregates as $aggregate) {

                    foreach ($aggregate->getEntities() as $entity) {

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($entity),
                            useStatements: [
                                DomainEntityMaker::getFullName($entity),
                                DomainEntityRepositoryMaker::getFullName($entity),
                                CommandNotFoundEntityException::class,
                                CommandRequiredEntityException::class,
                            ]
                        );

                        //replace file; so delete existing
                        $this->deleteClassFile($class_data->getFullClassName());

                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('CommandEntityGetter.php'),
                            variables: [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($entity),
                                'makers' => $this->makers,
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
}