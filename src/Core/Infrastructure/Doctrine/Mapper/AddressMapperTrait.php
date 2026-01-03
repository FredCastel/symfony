<?php

namespace Core\Infrastructure\Doctrine\Mapper;

use Core\Domain\ValueObject\Address;
use Core\Domain\ValueObject\AddressCommunication;
use Core\Domain\ValueObject\AddressLocation;
use Core\Domain\ValueObject\City;
use Core\Domain\ValueObject\Country;
use Core\Domain\ValueObject\DateTime;
use Core\Domain\ValueObject\Email;
use Core\Domain\ValueObject\GeographicCoordinates;
use Core\Domain\ValueObject\Longitude;
use Core\Domain\ValueObject\Latitude;
use Core\Domain\ValueObject\Name;
use Core\Domain\ValueObject\PhoneNumber;
use Core\Domain\ValueObject\Street;
use Core\Domain\ValueObject\ValidityPeriod;
use Core\Domain\ValueObject\ZipCode;
use Core\Infrastructure\Doctrine\Entity\DoctrineAddressInterface;
use Core\Infrastructure\Doctrine\Type\DoctrineAddress;

trait AddressMapperTrait
{
    public function addressToModel(?DoctrineAddressInterface $entity): Address
    {
        $since = $entity->getAddress()->validSince;
        $until = $entity->getAddress()->validUntil;

        return new Address(
            name: new Name($entity->getAddress()->name),
            validityPeriod: new ValidityPeriod(
                since: new DateTime($since->format(\DateTimeImmutable::W3C)),
                until: new DateTime($until->format(\DateTimeImmutable::W3C)),
            ),
            location: new AddressLocation(
                street: new Street($entity->getAddress()->street),
                zipCode: new ZipCode($entity->getAddress()->zipCode),
                city: new City($entity->getAddress()->city),
                country: new Country($entity->getAddress()->country),
                coordinates: new GeographicCoordinates(
                    longitude: new Longitude($entity->getAddress()->longitude),
                    latitude: new Latitude($entity->getAddress()->latitude),
                ),
            ),
            commmunication: new AddressCommunication(
                email: new Email($entity->getAddress()->email),
                phone: new PhoneNumber($entity->getAddress()->phone),
                mobile: new PhoneNumber($entity->getAddress()->mobile),
            )
        );
    }
    public function addressFromModel(?DoctrineAddressInterface $entity, ?Address $address): ?DoctrineAddressInterface
    {
        if ($address == null)
            return null;

        $entity
            ->setAddress(new DoctrineAddress(
                name: $address->getName()->value,
                street: $address->getLocation()->getStreet()->value,
                zipCode: $address->getLocation()->getZipCode()->value,
                city: $address->getLocation()->getCity()->value,
                country: $address->getLocation()->getCountry()->value,
                longitude: $address->getLocation()->getCoordinated()->getLongitude()->value,
                latitude: $address->getLocation()->getCoordinated()->getLatitude()->value,
                email: $address->getCommmunication()->getEmail()->value,
                phone: $address->getCommmunication()->getPhone()->value,
                mobile: $address->getCommmunication()->getMobile()->value,
                validSince: $address->getValidityPeriod()->getSince() ? new \DateTimeImmutable((string) $address->getValidityPeriod()->getSince()) : null,
                validUntil: $address->getValidityPeriod()->getUntil() ? new \DateTimeImmutable((string) $address->getValidityPeriod()->getUntil()) : null,
            ))
        ;

        return $entity;
    }
}