<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\Remove;

use Core\Application\Command\CommandRequest;

final class RemoveRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
    ) {
    }
}
