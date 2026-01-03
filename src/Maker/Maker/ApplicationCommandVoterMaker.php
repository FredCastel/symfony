<?php

namespace Maker\Maker;

use Core\Application\Command\CommandIdVoter;
use Core\Application\Command\CommandVoterException;
use Core\Application\Message\InformationMessage;
use Core\Application\Response\Notification;
use Maker\Element\ApplicationElement;
use Maker\Element\CommandElement;
use Maker\Template\MakerTemplate;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class ApplicationCommandVoterMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'command_voter';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new command aggregate voter class');
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
        return $object->name . 'Voter';

    }

    public function runGenerate(ApplicationElement $def, Generator $generator): void
    {
        echo "Generating Application Command Voters...\n";
        
        foreach ($def->namespaces as $namespace) {

            foreach ($namespace->contexts as $context) {

                foreach ($context->aggregates as $aggregate) {

                    foreach ($aggregate->commands as $command) {
                        $action = $command->getTargetAction();
                        $entity = $action->entity;

                        if($entity->isRoot() && $action->isInsertAction()) {
                            //no voter for insert action
                            continue;
                        }

                        $useStatements = [];
                        $useStatements[] = DomainEntityMaker::getFullName($entity);
                        $useStatements[] = DomainEntityRepositoryMaker::getFullName($entity);
                        $useStatements[] = ApplicationCommandEntityGetterMaker::getFullName($entity);

                        $class_data = ClassData::create(
                            class: static::$generatedPath . self::getFullName($command),
                            extendsClass: CommandIdVoter::class,
                            useStatements: [
                                ...$useStatements,
                                CommandIdVoter::class,
                                CommandVoterException::class,
                                InformationMessage::class,
                                Notification::class,
                            ]
                        );

                        //replace file; so delete existing
                        $this->deleteClassFile($class_data->getFullClassName());

                        $generator->generateClass(
                            className: $class_data->getFullClassName(),
                            templateName: MakerTemplate::getPath('CommandVoter.php'),
                            variables: [
                                'class_data' => $class_data,
                                'ns' => self::getNamespace($command),
                                'makers' => $this->makers,
                                'command' => $command,
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