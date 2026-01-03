<?php

namespace Maker\Maker;

use Core\Infrastructure\Doctrine\DoctrineEntityRepository;
use Maker\Element\ApplicationElement;
use Maker\Element\ResourceElement;
use Maker\Template\MakerTemplate;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class DoctrineEntityRepositoryMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'doctrine_repository_entity';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new doctrine repository for an entity');
    }

    /**
     * Summary of getNamespace
     * @param ResourceElement $object
     * @return string
     */
    public static function getNamespace(object $object): string
    {
        return $object->context->namespace->name . '\Infrastructure\Doctrine\Repository\\' . $object->context->name;
    }

    /**
     * Summary of getName
     * @param ResourceElement $object
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return 'Doctrine' . ucfirst($object->name) . 'EntityRepository';
    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Doctrine Entity Repositories...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource) {
                    $entity = $resource->getTargetEntity();

                    $useStatements = [];
                    foreach ($resource->associations as $association) {
                        $useStatements[] = DomainEntityMaker::getFullName($association->getTargetRelation()->getTargetEntity());
                        $useStatements[] = DoctrineMapperMaker::getFullName($association->getTargetResource());
                    }

                    $class_data = ClassData::create(
                        class: static::$generatedPath . self::getFullName($resource),
                        extendsClass: DoctrineEntityRepository::class,
                        useStatements: [
                            ...$useStatements,
                            ManagerRegistry::class,
                            DomainEntityMaker::getFullName($entity),
                            DomainAggregateRepositoryMaker::getFullName($entity->aggregate),
                            DomainEntityRepositoryMaker::getFullName($entity),
                            DoctrineEntityMaker::getFullName($resource),
                            DoctrineMapperMaker::getFullName($resource),
                            DoctrineEntityRepository::class,
                        ]
                    );

                    //replace file; so delete existing
                    $this->deleteClassFile($class_data->getFullClassName());

                    $generator->generateClass(
                        className: $class_data->getFullClassName(),
                        templateName: MakerTemplate::getPath('DoctrineEntityRepository.php'),
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