<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\RegisterBankAccount;

use Core\Application\Command\CommandRequest;

final class RegisterBankAccountRequest implements CommandRequest
{
    public function __construct(
        public string $id,
        public string $entity_id,
        public string $name,
        public string $currency,
        public string $partyId,
        public string $bankId,
    ) {
    }
}
