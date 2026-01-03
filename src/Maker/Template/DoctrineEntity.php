<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

#[Entity()]
#[Table(name: "<?= $resource->tableName ?>")]
<?= str_replace('final', '' ,$class_data->getClassDeclaration()) ?>
{
    /************* Entity Fields */

    #[Id]
    #[Column(type: UuidType::NAME, unique: true)]
    private ?Uuid $id = null;

    <?php foreach ($resource->fields as $field): ?>
    #[Column(
        <?= $field->length ? ("length:".$field->length.",") : null ?>
        <?= $field->nullable ? ("nullable: true,") : null ?>
    )]
    private ?<?= $field->type ?> $<?= $field->name ?> = null;

    <?php endforeach; ?>

    /************* Entity Relations */

    <?php foreach ($resource->associations as $association): ?>
    #[ManyToOne(targetEntity: <?= $makers->doctrineEntityMaker::getName($association->getTargetResource()) ?>::class)]
    #[JoinColumn(<?= $association->nullable ? 'nullable: true' : null ?>)]
    private ?<?= $makers->doctrineEntityMaker::getName($association->getTargetResource()) ?> $<?= $association->name ?> = null;

    <?php endforeach; ?>    
    /************* Constructor */

    public function __construct()
    {
        
    }

    /************* Entity Fields Getter and Setter */

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    <?php foreach ($resource->fields as $field): ?>
    public function get<?= ucfirst($field->name) ?>(): ?<?= $field->type ?>
    {
        return $this-><?= $field->name ?>;
    }

    public function set<?= ucfirst($field->name) ?>(<?= $field->nullable ? '?' : ''  ?><?= $field->type ?> $<?= $field->name ?>): self
    {
        $this-><?= $field->name ?> = $<?= $field->name ?>;

        return $this;
    }
    <?php endforeach; ?>

    /************* Entity Relations Getter and Setter */

    <?php foreach ($resource->associations as $association): ?>
    public function get<?= ucfirst($association->name) ?>(): ?<?= $makers->doctrineEntityMaker::getName($association->getTargetResource()) ?>
    {
        return $this-><?= $association->name ?>;
    }

    public function set<?= ucfirst($association->name) ?>(?<?= $makers->doctrineEntityMaker::getName($association->getTargetResource()) ?> $<?= $association->name ?>): self
    {
        $this-><?= $association->name ?> = $<?= $association->name ?>;

        return $this;
    }
    <?php endforeach; ?>

}