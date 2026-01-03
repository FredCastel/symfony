<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\RenameBank;

use Core\Application\Command\CommandRequest;

final class RenameBankRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public string $name,
        public string $url,
        public string $bic,
    ) {
    }
}
