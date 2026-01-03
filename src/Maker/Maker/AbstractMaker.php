<?php

namespace Maker\Maker;

use Maker\Element\ApplicationElement;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker as SymfonyAbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

abstract class AbstractMaker extends SymfonyAbstractMaker
{
    protected static int $counter = 0;
    protected static $commandNamePrefix = 'make:ddd:';
    protected static $generatedPath = '';

    protected static FileManager $fileManager;

    private ?ApplicationElement $app = null;

    public function __construct(
        public readonly MakerCollection $makers,
    ) {
    }

    abstract public static function getNamespace(object $object): string;
    abstract public static function getName(object $object, string $prefix = '', string $suffix = ''): string;
    public static function getFullName(object $object, string $prefix = '', string $suffix = ''): string
    {
        return static::getNamespace($object) . '\\' . static::getName($object, $prefix, $suffix);
    }
    
    /**
     * Configure any library dependencies that your maker requires.
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {

    }

    /**
     * If necessary, you can use this method to interactively ask the user for input.
     */
    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {

    }

    abstract public function runGenerate(ApplicationElement $def, Generator $generator): void;

    /**
     * Called after normal code generation: allows you to do anything.
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        //$this->generator = $generator;
        //we need to access the file manager
        // option 1 : inject it in construcor => wrong due to circular ref due to maker collection
        // option 2 : get it from generator private property

        $reflectedProperty = new \ReflectionProperty(Generator::class, property: 'fileManager');
        self::$fileManager = ($reflectedProperty)->getValue($generator);
        
        $this->runGenerate(ApplicationElement::get(), $generator);

        $io->text([
            'finished, ' . self::$counter . ' files generated',
        ]);
        $this->writeSuccessMessage($io);

    }

    public function deleteClassFile($className)
    {
        $path = self::$fileManager->getRelativePathForFutureClass($className);
        $filesystem = new Filesystem();
        $filesystem->remove($path);
    }
}