# Value Objects

## Address

Adds useful methods for an address.

```php
use Fire\ValueObject\Address;
use Fire\ValueObject\AddressFormat;

$address = new Address($street, $city, $state, $zip);
$address = new Address('Street', 'City', 'ST', '99999');

// Tests that there is at least one part of the address,
// not that it is a valid physical address
if ($address->isValid()) {
    echo $address->format();
    // Street<br>City, ST 99999

    echo $address->format(
        (new AddressFormat())
            ->setZip(false)
            ->setSeparator(', ')
    ]);
    // Street, City, St
}
```

### Methods

#### `street()`

Return street.

```php
Street: <?php echo $address->street() ?>
```

#### `city()`

Return city.

```php
City: <?php echo $address->city() ?>
```

#### `state()`

Return state.

```php
State: <?php echo $address->state() ?>
```

#### `zip()`

Return zip code.

```php
Zip code: <?php echo $address->zip() ?>
```

#### `isValid()`

Test whether there is at least one non-empty address component.

```php
<?php if ($address->isValid()): ?>
    <address>
        <?php echo $address->format() ?>
    </address>
<?php endif ?>
```

#### `format()`

Return the full address with optional formatting between each component.

```php
echo $address->format();

echo $address->format(
    (new AddressFormat())
        ->setZip(false)
        ->setSeparator(' ')
        ->setStreetSeparator("\n")
        ->setCitySeparator(', ')
        ->setStateSeparator('. ')
);
```

## Google Map Address

This class extends above `Address` class to offer methods to return directions and embed URLs. It also supports an optional [Place ID](https://developers.google.com/places/place-id).

Map embed URL requires an API key. By default the environment variable `GOOGLE_API_KEY` will be used, or you can set it via the static `setApiKey()` method.

```php
use Fire\ValueObject\GoogleMapAddress;

new GoogleMapAddress($street, $city, $state, $zip, $placeId);
```

### Methods

#### `placeId()`

Return [Google Place ID](https://developers.google.com/places/place-id).

```php
echo $address->placeId();
```

#### `directionsUrl()`

Return URL to Google Maps directions.

```php
echo $address->directionsUrl();
// https://www.google.com/maps/dir/?api=1&destination=123+Fake+St%2C+City%2C+ST%2C+99999&destination_place_id=abcdef
```

#### `embedUrl()`

Return URL to embeddable Google Map. Optional [`mode`](https://developers.google.com/maps/documentation/embed/guide#basic_map_modes) and `origin` values are accepted.

```php
<iframe src="<?php echo $address->embedUrl() ?>"></iframe>
<iframe src="<?php echo $address->embedUrl('directions', '123 Fake St, City, ST, 99999') ?>"></iframe>
```

#### `hasDirections()`

Test whether there is either any non-empty address components or Google Place ID that can be used to generate directions URL.

```php
<?php if ($address->hasDirections()): ?>
    <a href="<?php echo $address->directionsUrl() ?>">Directions</a>
<?php endif ?>
```

#### `canEmbed()`

Test whether there is an API key and that there is either any non-empty address components or Google Place ID that can be used to generate directions URL.

```php
<?php if ($address->canEmbed()): ?>
    <iframe src="<?php echo $address->embedUrl() ?>"></iframe>
<?php endif ?>
```

#### `setApiKey()`

Set the Google API key. If this is not set it will fallback to the value of the `GOOGLE_API_KEY` environment variable.

```php
use Fire\ValueObject\GoogleMapAddress;

GoogleMapAddress::setApiKey('abcdef');
```
