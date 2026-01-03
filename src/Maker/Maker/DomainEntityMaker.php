<?php

namespace Maker\Maker;

use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\EntityValidationException as AggregateEntityValidationException;
use Core\Domain\Aggregate\EventApplierException;
use Core\Domain\Model\EntityValidationException;
use Maker\Element\ApplicationElement;
use Maker\Element\EntityElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class DomainEntityMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'domain_entity';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new domain entity class');
    }

    /**
     * Summary of getNamespace
     * @param EntityElement $object
     * @return string
     */
    public static function getNamespace(object $object): string
    {
        return $object->aggregate->context->namespace->name . '\Domain\Aggregate\\' . $object->aggregate->context->name . '\Entity';
    }
    /**
     * Summary of getName
     * @param EntityElement $object
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return ucfirst($object->name);
    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Domain Entities...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->aggregates as $aggregate) {

                    foreach ($aggregate->getEntities() as $entity) {

                        $useStatements = [];
                        //use events
                        foreach ($entity->actions as $action) {
                            $useStatements[] = DomainEventMaker::getFullName($action);
                        }
                        //use children events
                        foreach ($entity->entities as $child) {
                            foreach ($child->actions as $action) {
                                $useStatements[] = DomainEventMaker::getFullName($action);
                            }
                        }

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($entity),
                            extendsClass: DomainEntityAbstractMaker::getFullName($entity),
                            useStatements: [
                                ...$useStatements,
                                //Id::class,
                                Entity::class,
                                EventApplierException::class,
                                AggregateEntityValidationException::class,
                                DomainAggregateMaker::getFullName($entity->aggregate),
                                DomainEntityMaker::getFullName($entity),
                            ]
                        );

                        //DO NOT replace file
                        $this->deleteClassFile($class_data->getFullClassName());

                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('DomainEntity.php'),
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