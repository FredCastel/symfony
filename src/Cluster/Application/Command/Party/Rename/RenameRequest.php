<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\Rename;

use Core\Application\Command\CommandRequest;

final class RenameRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public string $name,
    ) {
    }
}
