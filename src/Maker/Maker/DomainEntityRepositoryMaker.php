<?php

namespace Maker\Maker;

use Core\Domain\Aggregate\Entity;
use Core\Domain\Repository\EntityRepository;
use Maker\Element\ApplicationElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class DomainEntityRepositoryMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'domain_repository_entity';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new domain repository for an entity');
    }

    /**
     * Summary of getNamespace
     * @param EntityElement $object
     * @return string
     */
    public static function getNamespace(object $object): string
    {
        return $object->aggregate->context->namespace->name . '\Domain\Repository\\' . $object->aggregate->context->name;
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
        return ucfirst($object->name) . 'EntityRepository';
    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Domain Entity Repositories...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->aggregates as $aggregate) {

                    foreach ($aggregate->getEntities() as $entity) {

                        $useStatements = [];
                        foreach ($entity->relations as $relation) {
                            $useStatements[] = DomainEntityMaker::getFullName($relation->getTargetEntity());
                        }

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($entity),
                            extendsClass: EntityRepository::class,
                            useStatements: [
                                ...$useStatements,
                                DomainEntityMaker::getFullName($entity),
                                Entity::class,
                                EntityRepository::class,
                            ]
                        );

                        //replace file; so delete existing
                        $this->deleteClassFile($class_data->getFullClassName());

                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('DomainEntityRepository.php'),
                            variables: [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($entity),
                                'makers' => $this->makers,
                                'entity' => $entity
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