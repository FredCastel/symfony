<?php

namespace Maker\Maker;

use Core\Domain\Event\AbstractEvent;
use Maker\Element\ApplicationElement;
use Maker\Element\ActionElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class DomainEventMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'domain_event';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new domain event for an aggregate');
    }

    /**
     * Summary of getNamespace
     * @param ActionElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->context->namespace->name . '\Domain\Event\\' . $object->context->name;

    }
    /**
     * Summary of getName
     * @param ActionElement $object
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return ucfirst($object->eventName) . 'Event';
    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Domain Events...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->aggregates as $aggregate) {

                    foreach ($aggregate->getActions() as $action) {

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($action),
                            extendsClass: AbstractEvent::class,
                            useStatements: [
                                AbstractEvent::class,
                            ]
                        );

                        //replace file; so delete existing
                        $this->deleteClassFile($class_data->getFullClassName());

                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('DomainEvent.php'),
                            variables: [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($action),
                                'makers' => $this->makers,
                                'action' => $action,
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