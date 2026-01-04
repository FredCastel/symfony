<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\RegisterBank;

use Core\Application\Command\CommandRequest;

final class RegisterBankRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public string $name,
        public string $country,
        public ?string $url = null,
        public ?string $bic = null,
    ) {
    }
}
