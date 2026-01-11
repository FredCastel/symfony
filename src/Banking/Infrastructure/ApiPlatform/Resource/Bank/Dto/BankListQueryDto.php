<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Banking\Infrastructure\Doctrine\Entity\DoctrineBank;

final class BankListQueryDto
{
    public string $id;

    public ?string $name;

    public ?string $countrycode;

    public static function mapEntityToDto(?DoctrineBank $doctrineEntity): ?self
    {
        if (null == $doctrineEntity) {
            return null;
        }

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
        $dto->name = $doctrineEntity->getname();

        $dto->countrycode = $doctrineEntity->getcountrycode();

        return $dto;
    }
}
