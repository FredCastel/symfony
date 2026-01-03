<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class AddressCommunication extends ValueObject
{
    public function __construct(
        protected ?Email $email,
        protected ?PhoneNumber $phone,
        protected ?PhoneNumber $mobile,
    ) {
    }

    public function isInitial(): bool
    {
        return
            $this->email?->isInitial() &&
            $this->phone?->isInitial() &&
            $this->mobile?->isInitial();
    }
    public function getEmail(): Email
    {
        return $this->email;
    }
    public function getMobile(): PhoneNumber
    {
        return $this->mobile;
    }
    public function getPhone(): PhoneNumber
    {
        return $this->phone;
    }

    protected function internalCheck(): void
    {

    }

    public function __toString()
    {
        $str = "";
        if ($this->email)
            $str .= 'email: ' . $this->email->__toString();
        if ($this->phone)
            $str .= 'phone: ' . $this->phone->__toString();
        if ($this->mobile)
            $str .= 'mobile: ' . $this->mobile->__toString();

        return (string) $str;
    }

    public function jsonSerialize(): mixed
    {
        $array = [];
        if ($this->email)
            $array['email'] = json_encode($this->email);
        if ($this->phone)
            $array['phone'] = json_encode($this->phone);
        if ($this->mobile)
            $array['mobile'] = json_encode($this->mobile);
        return $array;
    }
}