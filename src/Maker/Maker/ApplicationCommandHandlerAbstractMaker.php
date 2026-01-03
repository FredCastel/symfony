<?php

namespace Maker\Maker;

use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Domain\Aggregate\AggregateValidator;
use Maker\Element\ApplicationElement;
use Maker\Element\CommandElement;
use Maker\Template\MakerTemplate;
use Core\Service\IdGenerator;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class ApplicationCommandHandlerAbstractMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'command_handler_abstract';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new command abstract handler class');
    }

    /**
     * Summary of getNamespace
     * @param CommandElement $object
     * @return string
     */
    public static function getNamespace(object $object): string
    {
        return $object->aggregate->context->namespace->name . '\Application\Command\\' . $object->aggregate->context->name . '\\' . $object->name;

    }
    /**
     * Summary of getName
     * @param CommandElement $object
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return 'Abstract'.ucfirst($object->name) . 'Handler';
    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Application Command Abstract Handlers...\n";

        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->aggregates as $aggregate) {

                    foreach ($aggregate->commands as $command) {
                        $action = $command->getTargetAction();
                        $entity = $action->entity;

                        $useStatements = [];
                        $useStatements[] = DomainAggregateMaker::getFullName($aggregate);
                        $useStatements[] = DomainAggregateRepositoryMaker::getFullName($aggregate);
                        $useStatements[] = ApplicationCommandAggregateGetterMaker::getFullName($aggregate);
                        $useStatements[] = DomainEntityMaker::getFullName($entity);
                        $useStatements[] = DomainEntityRepositoryMaker::getFullName($entity);
                        $useStatements[] = ApplicationCommandEntityGetterMaker::getFullName($entity);
                        if ($action->isInsertAction()) {
                            $useStatements[] = IdGenerator::class;
                        }

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($command),
                            useStatements: [
                                ...$useStatements,
                                CommandRequest::class,
                                CommandHandler::class,
                                CommandResponse::class,
                                AggregateValidator::class,
                            ]
                        );

                        //replace file; so delete existing
                        $this->deleteClassFile($class_data->getFullClassName());

                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('CommandHandlerAbstract.php'),
                            variables: [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($command),
                                'makers' => $this->makers,
                                'command' => $command,
                                'aggregate' => $aggregate,
                                'entity' => $entity,
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