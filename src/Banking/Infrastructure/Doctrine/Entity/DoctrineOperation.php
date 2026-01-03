<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\Entity;

use Core\Infrastructure\Doctrine\DoctrineEntity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity()]
#[Table(name: 'banking_operation')]
class DoctrineOperation extends DoctrineEntity
{
    /************* Entity Fields */

    #[Id]
    #[Column(type: UuidType::NAME, unique: true)]
    private ?Uuid $id = null;

    #[Column(
    )]
    private ?string $label = null;

    #[Column(
        length: 20, )]
    private ?string $state = null;

    #[Column(
        length: 20, )]
    private ?string $category = null;

    #[Column(
    )]
    private ?float $amount = null;

    #[Column(
    )]
    private ?\DateTimeImmutable $valuedate = null;

    #[Column(
    )]
    private ?\DateTimeImmutable $operationdate = null;

    /************* Entity Relations */

    /************* Constructor */

    public function __construct()
    {
    }

    /************* Entity Fields Getter and Setter */

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getValuedate(): ?\DateTimeImmutable
    {
        return $this->valuedate;
    }

    public function setValuedate(\DateTimeImmutable $valuedate): self
    {
        $this->valuedate = $valuedate;

        return $this;
    }

    public function getOperationdate(): ?\DateTimeImmutable
    {
        return $this->operationdate;
    }

    public function setOperationdate(\DateTimeImmutable $operationdate): self
    {
        $this->operationdate = $operationdate;

        return $this;
    }

    /************* Entity Relations Getter and Setter */
}
