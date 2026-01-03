<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\Disable;

use Core\Application\Command\CommandRequest;

final class DisableRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
    ) {
    }
}
