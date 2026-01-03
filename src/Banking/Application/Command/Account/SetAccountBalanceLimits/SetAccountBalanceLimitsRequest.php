<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\SetAccountBalanceLimits;

use Core\Application\Command\CommandRequest;

final class SetAccountBalanceLimitsRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public float $minimum,
        public float $maximum,
    ) {
    }
}
