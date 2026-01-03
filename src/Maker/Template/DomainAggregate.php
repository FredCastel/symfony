<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

/**
* <?= $aggregate->description ?> 
* @internal GENERATED class NEVER CHANGE IT
*/ 
<?= $class_data->getClassDeclaration() ?>
{
    /** @var <?= $makers->domainEntityMaker::getName($aggregate->root) ?> */
    protected EntityRoot $root;

    protected function initRoot(): void{
        $this->root = new <?= $makers->domainEntityMaker::getName($aggregate->root) ?>(id: $this->id, aggregate: $this);
    }

    /**
     * @return <?= $makers->domainEntityMaker::getName($aggregate->root) ?>
     */
    public function getRoot(): EntityRoot{
        return $this->root;
    }    
}