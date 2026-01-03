<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\OpenAccount;

use Core\Application\Command\CommandRequest;

final class OpenAccountRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
    ) {
    }
}
