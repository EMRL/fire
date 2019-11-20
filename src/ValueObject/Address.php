<?php

declare(strict_types=1);

namespace Fire\ValueObject;

class Address
{
    /** @var string $street */
    protected $street;

    /** @var string $city */
    protected $city;

    /** @var string $state */
    protected $state;

    /** @var string $zip */
    protected $zip;

    public function __construct(
        string $street = '',
        string $city = '',
        string $state = '',
        string $zip = ''
    ) {
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
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

    public function format(AddressFormat $format = null): string
    {
        $format = $format ?: new AddressFormat();

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
