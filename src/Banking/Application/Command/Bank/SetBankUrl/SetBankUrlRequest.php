<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\SetBankUrl;

use Core\Application\Command\CommandRequest;

final class SetBankUrlRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public ?string $url = null,
    ) {
    }
}
