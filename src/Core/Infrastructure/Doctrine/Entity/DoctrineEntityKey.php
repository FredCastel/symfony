<?php

namespace Core\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity()]
#[ORM\Table(name: "entity")]
class DoctrineEntityKey {
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?Uuid $id = null;

    #[ORM\Column(type: UuidType::NAME, name:"aggregate_id")]
    private ?Uuid $aggregateId = null;

    public function getId(): ?Uuid {
        return $this->id;
    }
    public function setId(Uuid $id): self {
        $this->id = $id;

        return $this;
    }

    public function getAggregateId(): ?Uuid {
        return $this->aggregateId;
    }
    public function setAggregateId(Uuid $aggregateId): self {
        $this->aggregateId = $aggregateId;

        return $this;
    }
}