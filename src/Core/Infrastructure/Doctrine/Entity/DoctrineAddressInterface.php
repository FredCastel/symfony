<?php

namespace Core\Infrastructure\Doctrine\Entity;

use Core\Infrastructure\Doctrine\Type\DoctrineAddress;

interface DoctrineAddressInterface
{
    public function getAddress(): ?DoctrineAddress;
    public function setAddress(DoctrineAddress $address): DoctrineAddressInterface;
}