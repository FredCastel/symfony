<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\SetBankBic;

use Core\Application\Command\CommandRequest;

final class SetBankBicRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public ?string $bic = null,
        public string $name,
        public ?string $url = null,
    ) {
    }
}
