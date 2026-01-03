<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\Entity;

use Cluster\Infrastructure\Doctrine\Entity\DoctrineParty;
use Core\Infrastructure\Doctrine\DoctrineEntity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity()]
#[Table(name: 'banking_account')]
class DoctrineAccount extends DoctrineEntity
{
    /************* Entity Fields */

    #[Id]
    #[Column(type: UuidType::NAME, unique: true)]
    private ?Uuid $id = null;

    #[Column(
    )]
    private ?string $name = null;

    #[Column(
        length: 20, )]
    private ?string $state = null;

    #[Column(
        length: 20, )]
    private ?string $category = null;

    #[Column(
        length: 3, )]
    private ?string $currencycode = null;

    #[Column(
    )]
    private ?float $balance = null;

    #[Column(
        nullable: true, )]
    private ?float $initialbalance = null;

    #[Column(
        nullable: true, )]
    private ?float $minimumbalance = null;

    #[Column(
        nullable: true, )]
    private ?float $maximumbalance = null;

    #[Column(
    )]
    private ?\DateTimeImmutable $validityperiodsince = null;

    #[Column(
    )]
    private ?\DateTimeImmutable $validityperioduntil = null;

    /************* Entity Relations */

    #[ManyToOne(targetEntity: DoctrineBank::class)]
    #[JoinColumn(nullable: true)]
    private ?DoctrineBank $bankid = null;

    #[ManyToOne(targetEntity: DoctrineParty::class)]
    #[JoinColumn()]
    private ?DoctrineParty $partyid = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getCurrencycode(): ?string
    {
        return $this->currencycode;
    }

    public function setCurrencycode(string $currencycode): self
    {
        $this->currencycode = $currencycode;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getInitialbalance(): ?float
    {
        return $this->initialbalance;
    }

    public function setInitialbalance(?float $initialbalance): self
    {
        $this->initialbalance = $initialbalance;

        return $this;
    }

    public function getMinimumbalance(): ?float
    {
        return $this->minimumbalance;
    }

    public function setMinimumbalance(?float $minimumbalance): self
    {
        $this->minimumbalance = $minimumbalance;

        return $this;
    }

    public function getMaximumbalance(): ?float
    {
        return $this->maximumbalance;
    }

    public function setMaximumbalance(?float $maximumbalance): self
    {
        $this->maximumbalance = $maximumbalance;

        return $this;
    }

    public function getValidityperiodsince(): ?\DateTimeImmutable
    {
        return $this->validityperiodsince;
    }

    public function setValidityperiodsince(\DateTimeImmutable $validityperiodsince): self
    {
        $this->validityperiodsince = $validityperiodsince;

        return $this;
    }

    public function getValidityperioduntil(): ?\DateTimeImmutable
    {
        return $this->validityperioduntil;
    }

    public function setValidityperioduntil(\DateTimeImmutable $validityperioduntil): self
    {
        $this->validityperioduntil = $validityperioduntil;

        return $this;
    }

    /************* Entity Relations Getter and Setter */

    public function getBankid(): ?DoctrineBank
    {
        return $this->bankid;
    }

    public function setBankid(?DoctrineBank $bankid): self
    {
        $this->bankid = $bankid;

        return $this;
    }

    public function getPartyid(): ?DoctrineParty
    {
        return $this->partyid;
    }

    public function setPartyid(?DoctrineParty $partyid): self
    {
        $this->partyid = $partyid;

        return $this;
    }
}
