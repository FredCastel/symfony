<?php

namespace Core\Infrastructure\Doctrine\Entity;

use Core\Infrastructure\Doctrine\Type\DoctrineAddress;
use Doctrine\ORM\Mapping as ORM;

trait DoctrineAddressTrait
{
    #[ORM\Column(type: "address", nullable: true)]
    private ?DoctrineAddress $address = null;

    public function getAddress(): ?DoctrineAddress
    {
        return $this->address;
    }

    public function setAddress(DoctrineAddress $address): DoctrineAddressInterface
    {
        $this->address = $address;

        return $this;
    }
}