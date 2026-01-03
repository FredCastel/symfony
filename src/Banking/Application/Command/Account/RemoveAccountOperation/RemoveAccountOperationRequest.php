<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\RemoveAccountOperation;

use Core\Application\Command\CommandRequest;

final class RemoveAccountOperationRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
    ) {
    }
}
