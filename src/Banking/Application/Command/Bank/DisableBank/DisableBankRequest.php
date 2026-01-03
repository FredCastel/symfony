<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\DisableBank;

use Core\Application\Command\CommandRequest;

final class DisableBankRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
    ) {
    }
}
