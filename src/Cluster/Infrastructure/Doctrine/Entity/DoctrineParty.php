<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Infrastructure\Doctrine\Entity;

use Core\Infrastructure\Doctrine\DoctrineEntity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity()]
#[Table(name: 'cluster_party')]
class DoctrineParty extends DoctrineEntity
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
    )]
    private ?\DateTimeImmutable $validityperiodsince = null;

    #[Column(
    )]
    private ?\DateTimeImmutable $validityperioduntil = null;

    #[Column(
        nullable: true, )]
    private ?string $url = null;

    #[Column(
        nullable: true, )]
    private ?string $address = null;

    #[Column(
        nullable: true, )]
    private ?string $image = null;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /************* Entity Relations Getter and Setter */
}
