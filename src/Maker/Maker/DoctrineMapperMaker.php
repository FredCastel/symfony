<?php

namespace Maker\Maker;

use Core\Domain\Aggregate\AbstractEntity;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\Entity;
use Core\Infrastructure\Doctrine\DoctrineEntity;
use Core\Infrastructure\Doctrine\DoctrineEntityRepository;
use Core\Infrastructure\Doctrine\Mapper\AggregateMapper;
use Core\Infrastructure\Doctrine\Mapper\EntityMapper;
use Maker\Element\ApplicationElement;
use Maker\Element\ResourceElement;
use Maker\Maker\AbstractMaker;
use Maker\Maker\DoctrineEntityMaker;
use Maker\Maker\DoctrineEntityRepositoryMaker;
use Maker\Maker\DomainAggregateMaker;
use Maker\Maker\DomainEntityRepositoryMaker;
use Maker\Maker\DomainValueObjectMaker;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Uid\Uuid;

class DoctrineMapperMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'doctrine_mapper';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new infrastructure doctrine mapper class');
    }
    
    /**
     * Summary of getNamespace
     * @param ResourceElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->context->namespace->name . '\Infrastructure\Doctrine\Mapper';

    }
    
    /**
     * Summary of getNamespace
     * @param ResourceElement $object
     * @return string
     */
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return 'Doctrine' . ucfirst($object->name) . 'Mapper';

    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Doctrine Entity Mapper...\n";

        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource) {
                    $entity = $resource->getTargetEntity();

                    $useStatements = [];
                    //use value objects
                    foreach ($entity->properties as $property) {
                        $useStatements[] = DomainValueObjectMaker::getFullName($property->valueObject);
                    }
                    //associations
                    foreach ($resource->associations as $association) {
                        $useStatements[] = DoctrineEntityRepositoryMaker::getFullName($association->getTargetResource());
                        $useStatements[] = DomainEntityRepositoryMaker::getFullName($association->getTargetRelation()->entity);
                    }
/*
                    //entity : with root
                    $useStatements[] = DomainAggregateMaker::getFullName($entity->target_aggregate->root);
                    $useStatements[] = DomainRepositoryMaker::getFullName($entity->target_aggregate->root);
                    $useStatements[] = DoctrineEntityMaker::getFullName($entity->target_root_entity);
                    $useStatements[] = DoctrineRepositoryMaker::getFullName($entity->target_root_entity);*/

                    $class_data = ClassData::create(
                        class: static::$generatedPath . self::getFullName($resource),
                        extendsClass: EntityMapper::class,
                        useStatements: [
                            ...$useStatements,
                            EntityMapper::class,
                            DomainAggregateMaker::getFullName($entity->aggregate),
                            DomainEntityMaker::getFullName($entity),
                            DoctrineEntityMaker::getFullName($resource),
                            Uuid::class,
                            DoctrineEntity::class,
                            Aggregate::class,
                            Entity::class,

                        ]
                    );

                    //replace file; so delete existing
                    $this->deleteClassFile($class_data->getFullClassName());

                    $generator->generateClass(
                        className: $class_data->getFullClassName(),
                        templateName: MakerTemplate::getPath('DoctrineMapperEntity.php'),
                        variables: [
                            'class_data' => $class_data,
                            'ns' => self::getNamespace($resource),
                            'makers' => $this->makers,
                            'resource' => $resource,
                            "entity" => $entity,
                        ]
                    );

                    $generator->writeChanges();
                    self::$counter++;
                }
            }
        }
    }
}