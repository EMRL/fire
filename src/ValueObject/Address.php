<?php

declare(strict_types=1);

namespace Fire\ValueObject;

class Address
{
    public function __construct(
        protected readonly string $street = '',
        protected readonly string $city = '',
        protected readonly string $state = '',
        protected readonly string $zip = '',
    ) {
    }

    public function street(): string
    {
        return $this->street;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function state(): string
    {
        return $this->state;
    }

    public function zip(): string
    {
        return $this->zip;
    }

    public function isValid(): bool
    {
        return $this->street() || $this->city() || $this->state() || $this->zip();
    }

    public function format(AddressFormat $format = new AddressFormat()): string
    {
        return implode($format->streetSeparator(), array_filter([
            $this->street(),
            implode($format->citySeparator(), array_filter([
                $this->city(),
                implode($format->stateSeparator(), array_filter([
                    $this->state(),
                    $format->zip() ? $this->zip() : false,
                ])),
            ])),
        ]));
    }
}
