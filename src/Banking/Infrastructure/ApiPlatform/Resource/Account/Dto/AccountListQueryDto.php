<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use Banking\Infrastructure\Doctrine\Entity\DoctrineAccount;

final class AccountListQueryDto
{
    public string $id;

    public ?string $name;

    public ?string $category;

    public ?float $balance;

    public ?string $currencycode;

    public static function mapEntityToDto(?DoctrineAccount $doctrineEntity): ?self
    {
        if (null == $doctrineEntity) {
            return null;
        }

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
        $dto->name = $doctrineEntity->getname();

        $dto->category = $doctrineEntity->getcategory();

        $dto->balance = $doctrineEntity->getbalance();

        $dto->currencycode = $doctrineEntity->getcurrencycode();

        return $dto;
    }
}
