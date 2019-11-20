<?php

declare(strict_types=1);

namespace Fire\Tests\ValueObject;

use Fire\ValueObject\Address;
use Fire\ValueObject\AddressFormat;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{
    public function testValid(): void
    {
        $this->assertTrue((new Address('123'))->isValid());
        $this->assertFalse((new Address())->isValid());
    }

    public function testFormat(): void
    {
        $address = new Address('123 Fake St', 'City', 'ST', '99999');

        $this->assertSame(
            '123 Fake St<br>City, ST 99999',
            $address->format(),
            'Full address, default options'
        );

        $this->assertSame(
            "123 Fake St\nCity ST. 99999",
            $address->format(
                (new AddressFormat())
                    ->setStreetSeparator("\n")
                    ->setCitySeparator(' ')
                    ->setStateSeparator('. ')
            ),
            'Full address with custom separators'
        );

        $this->assertSame(
            '123 Fake St, City, ST, 99999',
            $address->format((new AddressFormat())->setSeparator(', ')),
            'Full address with global separator'
        );

        $address = new Address('', 'City', '', '99999');

        $this->assertSame(
            'City, 99999',
            $address->format(),
            'Partial address'
        );

        $this->assertSame(
            'City',
            $address->format((new AddressFormat())->setZip(false)),
            'Partial without zip'
        );
    }
}
