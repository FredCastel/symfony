<?php

namespace Maker\Maker;

use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\EntityRoot;
use Maker\Element\AggregateElement;
use Maker\Element\ApplicationElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class DomainAggregateMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'domain_aggregate';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new domain aggregate class');
    }

    /**
     * Summary of getNamespace
     * @param AggregateElement $object
     * @return string
     */
    public static function getNamespace(object $object): string
    {
        return $object->context->namespace->name . '\Domain\Aggregate\\' . $object->context->name;
    }
    /**
     * Summary of getName
     * @param AggregateElement $object
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return ucfirst($object->name).'Aggregate';
    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating domain aggregate classes...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->aggregates as $aggregate) {

                    $useStatements = [];
                    $useStatements[] = DomainEntityMaker::getFullName($aggregate->root);

                    $class_data = ClassData::create(
                        class: static::$generatedPath . self::getFullName($aggregate),
                        extendsClass: Aggregate::class,
                        useStatements: [
                            ...$useStatements,
                            Aggregate::class,
                            EntityRoot::class,
                        ]
                    );

                    //replace file; so delete existing
                    $this->deleteClassFile($class_data->getFullClassName());

                    $generator->generateClass(
                        className: $class_data->getFullClassName(),
                        templateName: MakerTemplate::getPath('DomainAggregate.php'),
                        variables: [
                            'class_data' => $class_data,
                            'ns' => self::getNamespace($aggregate),
                            'makers' => $this->makers,
                            'aggregate' => $aggregate,
                        ]
                    );

                    $generator->writeChanges();
                    self::$counter++;

                }
            }
        }
    }
}