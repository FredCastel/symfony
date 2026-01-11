<?php

namespace Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto;

use Cluster\Infrastructure\Doctrine\Entity\DoctrineParty;

final class PartyListQueryDto
{
    public string $id;

    public ?string $name;

    public ?string $category;

    public static function mapEntityToDto(?DoctrineParty $doctrineEntity): ?self
    {
        if (null == $doctrineEntity) {
            return null;
        }

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
        $dto->name = $doctrineEntity->getname();

        $dto->category = $doctrineEntity->getcategory();

        return $dto;
    }
}
