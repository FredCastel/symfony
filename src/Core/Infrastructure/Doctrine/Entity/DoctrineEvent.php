<?php

namespace Core\Infrastructure\Doctrine\Entity;

use Core\Infrastructure\Doctrine\DoctrineEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity()]
#[ORM\Table(name: "event")]
class DoctrineEvent {
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $aggregate = null;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $aggregateId = null;

    #[ORM\Column(type: "integer")]
    private ?int $version = null;

    #[ORM\Column(length: 255)]
    private ?string $event = null;

    #[ORM\Column(type: "json")]
    private ?string $payload = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $recordingDate = null;


    public function getId(): ?Uuid {
        return $this->id;
    }
    public function setId(Uuid $id): self {
        $this->id = $id;

        return $this;
    }

    public function getAggregate(): ?string {
        return $this->aggregate;
    }
    public function setAggregate(string $aggregate): self {
        $this->aggregate = $aggregate;

        return $this;
    }

    public function getAggregateId(): ?Uuid {
        return $this->aggregateId;
    }
    public function setAggregateId(Uuid $aggregateId): self {
        $this->aggregateId = $aggregateId;

        return $this;
    }

    public function getVersion(): ?int {
        return $this->version;
    }
    public function setVersion(int $version): self {
        $this->version = $version;

        return $this;
    }

    public function getEvent(): ?string {
        return $this->event;
    }
    public function setEvent(string $event): self {
        $this->event = $event;

        return $this;
    }

    public function getPayload(): ?string {
        return $this->payload;
    }
    public function setPayload(string|null $payload): self {
        $this->payload = $payload;

        return $this;
    }

    public function getRecordingDate(): ?\DateTimeImmutable {
        return $this->recordingDate;
    }
    public function setRecordingDate(\DateTimeImmutable $recordingDate): self {
        $this->recordingDate = $recordingDate;

        return $this;
    }
}