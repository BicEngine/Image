# Image Decoder

<p align="center">
    <a href="https://github.com/BicEngine/Image/actions"><img src="https://github.com/BicEngine/Image/workflows/build/badge.svg"></a>
</p>

## Requirements

- PHP ^8.1

## Installation

Library is available as composer repository and can be installed using the 
following command in a root of your project.

- `composer require bic-engine/image`

## Usage

### Reading

Some formats (for example: ICO, DDS, etc...) can be containers and contain 
multiple physical images inside, so the factory returns an iterator:

```php
$factory = new \Bic\Image\Factory();

foreach ($factory->fromPathname('path/to/image.bmp') as $i => $image) {
    // Expected: "#0: 640x480"
    echo \sprintf("#%d: %dx%d\n", $i, $image->getWidth(), $image->getHeight());

    // Expected: "Size: 42424 bytes"
    echo \sprintf("Size: %d bytes\n", $image->getBytes());

    // Expected: "Format: R8G8B8 (3 bytes per pixel)"
    $format = $image->getFormat();
    echo \sprintf("Format: %s (%d bytes per pixel)\n", $format->name, $format->getBytesPerPixel());
}
```

### Converting

```php
$converter = new \Bic\Image\Converter();

/**
 * Example input:
 *
 * $image = object(Bic\Image\Image) {
 *      // 3 bytes per pixel
 *      format: R8G8B8
 * }
 */
$image     = ...;

// Convert from R8G8B8 to A8B8G8R8
$to = $converter->convert($image, \Bic\Image\Format::A8B8G8R8);

/**
 * Example output:
 *
 * $to = object(Bic\Image\Image) {
 *      // 4 bytes per pixel
 *      format: A8B8G8R8
 * }
 */
```

### Add Decoders

```php
$factory = new \Bic\Image\Factory();
$factory->extend(new \Bic\Image\Ico\IcoDecoder());

$images = $factory->fromPathname('path/to/image.ico');
```
