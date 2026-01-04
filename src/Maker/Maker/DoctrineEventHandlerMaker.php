<?php

namespace Maker\Maker;

use Core\Domain\Event\AbstractEvent;
use Core\Domain\ValueObject\Id;
use Core\Infrastructure\Doctrine\EventHandler\AbstractPersistEventHandler;
use Maker\Element\ApplicationElement;
use Maker\Element\EntityElement;
use Maker\Template\MakerTemplate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class DoctrineEventHandlerMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'doctrine_event_handler';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new infrastructure doctrine event handler class');
    }

    /**
     * Summary of getNamespace
     * @param EntityElement $object
     * @return string
     */
    static public function getNamespace(object $object): string
    {
        return $object->aggregate->context->namespace->name . '\Infrastructure\Doctrine\EventHandler\QueryProjection\\' . $object->aggregate->context->name;

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
        return 'Doctrine' . ucfirst($object->name) . $suffix."EventHandler";

    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Doctrine Event Handlers...\n";

        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->resources as $resource ) {
                    $entity = $resource->getTargetEntity();

                    $useStatements = [];
                    foreach ($entity->actions as $action) {
                        $useStatements[] = DomainEventMaker::getFullName($action);
                    }
                    $useStatements[] = DomainAggregateMaker::getFullName($entity->aggregate);

                    //list handlers
                    $handlers=[];
                    $handlers[]=(object) array('name' => 'Persist', 'actionCheck'=>'isInsertAction');
                    $handlers[]=(object) array('name' => 'Change', 'actionCheck'=>'isUpdateAction');
                    $handlers[]=(object) array('name' => 'Remove', 'actionCheck'=>'isDeleteAction');

                    foreach ($handlers as $handler) {

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($entity,'',$handler->name),
                            extendsClass: AbstractPersistEventHandler::class,
                            useStatements: [
                                ...$useStatements,
                                DoctrineAggregateRepositoryMaker::getFullName($entity->aggregate),
                                DoctrineEntityRepositoryMaker::getFullName($resource),
                                DoctrineMapperMaker::getFullName($resource),
                                AbstractPersistEventHandler::class,
                                EntityManagerInterface::class,
                                AbstractEvent::class,
                                Id::class,
                            ]
                        );

                        //list of actions
                        $actions = [];
                        foreach ($entity->actions as $action) {
                            $check = $handler->actionCheck;
                            if (!$action->$check()) continue;
                            $actions[] = $action;
                        }

                        //replace file; so delete existing
                        $this->deleteClassFile($class_data->getFullClassName());

                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('DoctrineEventHandler.php'),
                            variables: [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($entity),
                                'makers' => $this->makers,
                                'resource' => $resource,
                                'entity' => $entity,
                                'actions' => $actions,
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