<?php

declare(strict_types=1);

namespace Fire\ValueObject;

class AddressFormat
{
    public function __construct(
        protected bool $zip = true,
        protected string $separator = '',
        protected string $streetSeparator = '<br>',
        protected string $citySeparator = ', ',
        protected string $stateSeparator = ' ',
    ) {
    }

    public function zip(): bool
    {
        return $this->zip;
    }

    public function setZip(bool $value): self
    {
        $this->zip = $value;
        return $this;
    }

    public function separator(): string
    {
        return $this->separator;
    }

    public function setSeparator(string $value): self
    {
        $this->separator = $value;
        return $this;
    }

    public function streetSeparator(): string
    {
        return $this->separator() ?: $this->streetSeparator;
    }

    public function setStreetSeparator(string $value): self
    {
        $this->streetSeparator = $value;
        return $this;
    }

    public function citySeparator(): string
    {
        return $this->separator() ?: $this->citySeparator;
    }

    public function setCitySeparator(string $value): self
    {
        $this->citySeparator = $value;
        return $this;
    }

    public function stateSeparator(): string
    {
        return $this->separator() ?: $this->stateSeparator;
    }

    public function setStateSeparator(string $value): self
    {
        $this->stateSeparator = $value;
        return $this;
    }
}
