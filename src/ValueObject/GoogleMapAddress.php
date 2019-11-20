<?php

declare(strict_types=1);

namespace Fire\ValueObject;

class GoogleMapAddress extends Address
{
    /** @var string DIRECTIONS_URL */
    public const DIRECTIONS_URL = 'https://www.google.com/maps/dir/?api=1';

    /** @var string EMBED_URL */
    public const EMBED_URL = 'https://www.google.com/maps/embed/v1/%s';

    /** @var string $apiKey */
    protected static $apiKey;

    /** @var string $placeId */
    protected $placeId;

    public function __construct(
        string $street = '',
        string $city = '',
        string $state = '',
        string $zip = '',
        string $placeId = ''
    ) {
        parent::__construct($street, $city, $state, $zip);
        $this->placeId = $placeId;
    }

    public function placeId(): string
    {
        return $this->placeId;
    }

    public function directionsUrl(): string
    {
        if (!$this->hasDirections()) {
            return '';
        }

        $params = [
            'destination' => $this->location(),
        ];

        if ($id = $this->placeId()) {
            $params['destination_place_id'] = $id;
        }

        return add_query_arg($params, static::DIRECTIONS_URL);
    }

    public function embedUrl(string $mode = 'place', string $origin = 'Current Location'): string
    {
        if (!$this->canEmbed()) {
            return '';
        }

        if (!in_array($mode, ['place', 'directions', 'search'], true)) {
            $mode = 'place';
        }

        $params = [
            'key' => static::apiKey(),
        ];

        if ($mode === 'place' || $mode === 'search') {
            $params['q'] = $this->placeIdOrLocation();
        } elseif ($mode === 'directions') {
            $params['origin'] = $origin;
            $params['destination'] = $this->placeIdOrLocation();
        }

        return add_query_arg($params, sprintf(static::EMBED_URL, $mode));
    }

    public function hasDirections(): bool
    {
        return $this->isValid() || $this->placeId();
    }

    public function canEmbed(): bool
    {
        return static::apiKey() && $this->hasDirections();
    }

    protected function location(): string
    {
        return $this->format((new AddressFormat())->setSeparator(', '));
    }

    protected function placeIdOrLocation(): string
    {
        if ($id = $this->placeId()) {
            return 'place_id:'.$id;
        }

        return $this->location();
    }

    protected static function apiKey(): string
    {
        return (string) (static::$apiKey ?: getenv('GOOGLE_API_KEY'));
    }

    public static function setApiKey(string $key): void
    {
        static::$apiKey = $key;
    }
}
