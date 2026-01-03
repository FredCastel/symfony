<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\AddAccountOperation;

use Core\Application\Command\CommandRequest;

final class AddAccountOperationRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public string $operationDate,
        public string $valueDate,
        public float $amount,
        public string $label,
    ) {
    }
}
