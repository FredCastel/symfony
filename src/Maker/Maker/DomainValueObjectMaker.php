<?php

namespace Maker\Maker;

use Core\Domain\ValueObject\ConstantValueObject;
use Maker\Element\ApplicationElement;
use Maker\Element\ValueObjectElement;
use Maker\Template\MakerTemplate;
use Core\Service\Assert\Assert;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Util\ClassSource\Model\ClassData;
use Symfony\Component\Console\Command\Command;

class DomainValueObjectMaker extends AbstractMaker
{

    /**
     * Return the command name for your maker (e.g. make:report).
     */
    public static function getCommandName(): string
    {
        return self::$commandNamePrefix . 'domain_vo';
    }

    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription('Create a new domain aggregate value object class');
    }

    /**
     * Summary of getNamespace
     * @param ValueObjectElement $object
     * @return string
     */
    public static function getNamespace(object $object): string
    {
        if ($object->isCore()) {
            return "Core\Domain\ValueObject";
        } else {
            return $object->namespace->name . '\Domain\ValueObject';
        }
    }
    /**
     * Summary of getName
     * @param ValueObjectElement $object
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function getName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return ucfirst($object->name);
    }

    public function runGenerate(ApplicationElement $app, Generator $generator): void
    {
        echo "Generating Domain Value Objects...\n";
        
        foreach ($app->namespaces as $namespace) {
            if ($namespace->name == 'Core') {
                continue;
            }
            foreach ($namespace->valueObjects as $valueObject) {
                if ($valueObject->isLocal()) {

                    //value oject
                    $class_data = ClassData::create(
                        class: static::$generatedPath . self::getFullName($valueObject),
                        extendsClass: self::getFullName($valueObject->getExtended()),
                        useStatements: [
                            self::getFullName($valueObject->getExtended()),
                            ConstantValueObject::class,
                            Assert::class,
                        ]
                    );

                    //replace file; so delete existing
                    $this->deleteClassFile($class_data->getFullClassName());

                    $generator->generateClass(
                        className: $class_data->getFullClassName(),
                        templateName: MakerTemplate::getPath('DomainValueObject.php'),
                        variables: [
                            'class_data' => $class_data,
                            'ns' => self::getNamespace($valueObject),
                            'makers' => $this->makers,
                            'valueObject' => $valueObject,
                        ]
                    );

                    $generator->writeChanges();
                    self::$counter++;
                }
            }
        }
    }
}