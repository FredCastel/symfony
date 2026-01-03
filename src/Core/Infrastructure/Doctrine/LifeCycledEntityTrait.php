<?php

namespace Core\Infrastructure\Doctrine;

use Doctrine\ORM\Mapping as ORM;

trait LifeCycledEntityTrait
{

    #[ORM\Column]
    protected ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    protected ?\DateTimeImmutable $changedAt = null;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getChangedAt(): ?\DateTimeImmutable
    {
        return $this->changedAt;
    }

    public function setChangedAt(?\DateTimeImmutable $changedAt): self
    {
        $this->changedAt = $changedAt;

        return $this;
    }
}