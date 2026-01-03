<?php

namespace Maker\Maker;

use Core\Domain\ValueObject\Id;
use Core\Infrastructure\Doctrine\DoctrineEntity;
use Maker\Element\ApplicationElement;
use Maker\Element\ResourceElement;
use Maker\Template\MakerTemplate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Uid\Uuid;

class DoctrineEntityMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'doctrine_entity';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new infrastructure doctrine entity class');
    }
    
    /**
     * Summary of getNamespace
     * @param ResourceElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->context->namespace->name . '\Infrastructure\Doctrine\Entity';

    }
    
    /**
     * Summary of getNamespace
     * @param ResourceElement $object
     * @return string
     */
    static public function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return 'Doctrine' . ucfirst($object->name);

    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource) {

                    $useStatements = [];
                    foreach ($resource->associations as $association) {
                        $useStatements[] = DoctrineEntityMaker::getFullName($association->getTargetResource());
                    }

                    $class_data = ClassData::create(
                        class: static::$generatedPath . self::getFullName($resource),
                        extendsClass: DoctrineEntity::class,
                        useStatements: [
                            ...$useStatements,
                            DoctrineEntity::class,
                            UuidType::class,
                            Uuid::class,
                            ORM\Entity::class,
                            ORM\Table::class,
                            ORM\Id::class,
                            ORM\Column::class,
                            ORM\ManyToOne::class,
                            ORM\JoinColumn::class,
                        ]
                    );

                    //replace file; so delete existing
                    $this->deleteClassFile($class_data->getFullClassName());

                    $generator->generateClass(
                        className: $class_data->getFullClassName(),
                        templateName: MakerTemplate::getPath('DoctrineEntity.php'),
                        variables: [
                            'class_data' => $class_data,
                            'ns' => self::getNamespace($resource),
                            'makers' => $this->makers,
                            'resource' => $resource,
                        ]
                    );

                    $generator->writeChanges();
                    self::$counter++;
                }
            }
        }
    }
}