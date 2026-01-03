<?php

declare(strict_types=1);

namespace Core\Infrastructure\ApiPlatform\Resource;

final class AddressDto
{
    public function __construct(
        public string|null $name,
        public string|null $street,
        public string|null $zipCode,
        public string|null $city,
        public string|null $country,
        public string|null $email,
        public int|null $phone,
        public int|null $mobile,
        public float|null $longitude,
        public float|null $latitude,
        public \DateTimeImmutable $validSince,
        public \DateTimeImmutable $validUntil,
    ) {

    }
}