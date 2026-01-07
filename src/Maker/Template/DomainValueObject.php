<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

/**
* <?= $valueObject->description ?> 
* @todo adjust this definition
*/ 
<?= $class_data->getClassDeclaration() ?>
{
    <?php if($valueObject->withValues()): ?>
    <?php foreach ($valueObject->values as $value): ?>
    public const <?= strtoupper($value) ?> = '<?= $value ?>';
    <?php endforeach ?>
    <?php endif ?>

    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    <?php if($valueObject->withValues()): ?>
    <?php foreach ($valueObject->values as $value): ?>
    public static function <?= strtoupper($value) ?>(): self
    {
        return new self(
            value: self::<?= strtoupper($value) ?>,
        );
    }
    <?php endforeach ?>

    /**
     * Summary of getAllowed
     * @return <?= $valueObject->name ?>[]<?= "\n" ?>
     */
    static public function getAllowed(): array
    {
        return array(
            <?php foreach ($valueObject->values as $value): ?>
            <?= $valueObject->name ?>::<?= strtoupper($value) ?>(),
            <?php endforeach ?>
        );
    }
    <?php else: ?>
    protected function internalCheck(): void
    {
        //TODO
        /*Assert::that($this->value)
            ->notNull()
            ->notEmpty()
            ->string()
            ->alnum()
            ->minLength(8)
            ->maxLength(11)
            ->regex('/^([a-zA-Z]{4})([a-zA-Z]{2})(([2-9a-zA-Z]{1})([0-9a-np-zA-NP-Z]{1}))((([0-9a-wy-zA-WY-Z]{1})([0-9a-zA-Z]{2}))|([xX]{3})|)/');
            */
    }
    <?php endif ?>
}