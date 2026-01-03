<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

/**
 * Event of the <?= $action->aggregate->name ?> aggegate
 * linked to <?= $action->name ?> action of <?= $action->entity->name ?> entity
 * <?= $action->name ?> : <?= $action->description ?> 
 * @internal GENERATED class NEVER CHANGE IT
 */
readonly <?= $class_data->getClassDeclaration() ?>
{
    /**
     * Create a new event <?= $action->eventName ?> 
     * linked to action <?= $action->name ?> 
     * of entity <?= $action->entity->name ?> 
     *
     * @param string $id the aggregate id
     * @param string $entity_id the entity id
     <?php foreach ($action->parameters as $parameter): ?>
     * @param <?= $parameter->nullable ? 'null|' : '' ?><?= $parameter->type ?> $<?= $parameter->name ?> <?= $parameter->description ?> 
     <?php endforeach; ?>
     */
    public function __construct(
        public string $id,
        public string $entity_id,
        <?php foreach ($action->parameters as $parameter): ?>
        public <?= $parameter->nullable ? '?' : '' ?><?= $parameter->type ?> $<?= $parameter->name ?>,
        <?php endforeach; ?>
    ) {
    parent::__construct($id,$entity_id);
    }
}