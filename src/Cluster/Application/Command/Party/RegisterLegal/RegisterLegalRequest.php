<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\RegisterLegal;

use Core\Application\Command\CommandRequest;

final class RegisterLegalRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public string $name,
        public ?string $url = null,
    ) {
    }
}
