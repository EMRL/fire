<?php

declare(strict_types=1);

namespace Fire\Tests\ValueObject;

use Fire\Tests\TestCase;
use Fire\ValueObject\GoogleMapAddress;

use function Brain\Monkey\Functions\when;

final class GoogleMapAddressTest extends TestCase
{
    public function testHasDirections(): void
    {
        $this->assertTrue((new GoogleMapAddress('', '', '', '', 'abcde'))->hasDirections());
        $this->assertTrue((new GoogleMapAddress('123 Fake St'))->hasDirections());
        $this->assertFalse((new GoogleMapAddress())->hasDirections());
    }

    public function testCanEmbed(): void
    {
        $address = new GoogleMapAddress('123 Fake St');
        $this->assertFalse($address->canEmbed());

        GoogleMapAddress::setApiKey('abcde');
        $this->assertTrue($address->canEmbed());

        GoogleMapAddress::setApiKey('');
        putenv('GOOGLE_API_KEY=acbde');
        $this->assertTrue($address->canEmbed(), 'Fallback to environment variable');
        putenv('GOOGLE_API_KEY');
    }

    public function testDirectionsUrl(): void
    {
        $this->functions();

        $this->assertSame(
            GoogleMapAddress::DIRECTIONS_URL.'&destination=123+Fake+St',
            (new GoogleMapAddress('123 Fake St'))->directionsUrl()
        );
    }

    public function testDirectionsUrlWithPlaceId(): void
    {
        $this->functions();

        $this->assertSame(
            GoogleMapAddress::DIRECTIONS_URL.'&destination=&destination_place_id=abcde',
            (new GoogleMapAddress('', '', '', '', 'abcde'))->directionsUrl()
        );
    }

    public function testEmptyDirectionsUrl(): void
    {
        $this->assertSame('', (new GoogleMapAddress())->directionsUrl());
    }

    public function testEmbedUrl(): void
    {
        $this->functions();

        GoogleMapAddress::setApiKey('abcde');

        $this->assertSame(
            sprintf(GoogleMapAddress::EMBED_URL, 'place').'?key=abcde&q=123+Fake+St',
            (new GoogleMapAddress('123 Fake St'))->embedUrl()
        );
    }

    public function testEmbedUrlDirectionsMode(): void
    {
        $this->functions();

        GoogleMapAddress::setApiKey('abcde');

        $this->assertSame(
            sprintf(GoogleMapAddress::EMBED_URL, 'directions')
                .'?key=abcde&origin=Current+Location&destination=place_id%3Afghij',
            (new GoogleMapAddress('', '', '', '', 'fghij'))->embedUrl('directions')
        );
    }

    public function testEmbedUrlInvalidMode(): void
    {
        $this->functions();

        GoogleMapAddress::setApiKey('abcde');

        $this->assertSame(
            sprintf(GoogleMapAddress::EMBED_URL, 'place').'?key=abcde&q=123+Fake+St',
            (new GoogleMapAddress('123 Fake St'))->embedUrl('invalid-mode')
        );
    }

    public function testEmptyEmbedUrl(): void
    {
        $this->assertSame('', (new GoogleMapAddress())->embedUrl());
    }

    protected function functions(): void
    {
        when('add_query_arg')->alias(function (array $params, string $url) {
            return $url.(strpos($url, '?') === false ? '?' : '&').http_build_query($params);
        });
    }
}
