<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\RegisterNatural;

use Core\Application\Command\CommandRequest;

final class RegisterNaturalRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public string $name,
        public string $address,
    ) {
    }
}
