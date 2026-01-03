<?php

namespace Maker\Maker;

use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Repository\AggregateRepository;
use Core\Infrastructure\Doctrine\DoctrineAggregateRepository;
use Maker\Element\AggregateElement;
use Maker\Element\ApplicationElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class DoctrineAggregateRepositoryMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'doctrine_repository_aggregate';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new doctrine repository for an aggregate');
    }

    /**
     * Summary of getNamespace
     * @param AggregateElement $object
     * @return string
     */
    public static function getNamespace(object $object): string
    {
        return $object->context->namespace->name . '\Infrastructure\Doctrine\Repository\\' . $object->context->name;
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
        return 'Doctrine' . ucfirst($object->name) . 'AggregateRepository';
    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Doctrine Aggregate Repositories...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->aggregates as $aggregate) {

                    $useStatements = [];

                    $class_data = ClassData::create(
                        class: static::$generatedPath . self::getFullName($aggregate),
                        extendsClass: DoctrineAggregateRepository::class,
                        useStatements: [
                            ...$useStatements,
                            DomainAggregateMaker::getFullName($aggregate),
                            DomainAggregateRepositoryMaker::getFullName($aggregate),
                            DoctrineAggregateRepository::class,
                        ]
                    );

                    //replace file; so delete existing
                    $this->deleteClassFile($class_data->getFullClassName());

                    $generator->generateClass(
                        className: $class_data->getFullClassName(),
                        templateName: MakerTemplate::getPath('DoctrineAggregateRepository.php'),
                        variables: [
                            'class_data' => $class_data,
                            'ns' => self::getNamespace($aggregate),
                            'makers' => $this->makers,
                            'aggregate' => $aggregate
                        ]
                    );

                    $generator->writeChanges();
                    self::$counter++;
                }
            }
        }
    }
}