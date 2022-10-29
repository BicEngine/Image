<?php

declare(strict_types=1);

namespace Bic\Image;

use Bic\Image\Exception\FormatException;

final class Converter implements ConverterInterface
{
    /**
     * {@inheritDoc}
     */
    public function convert(ImageInterface $image, PixelFormat $output): ImageInterface
    {
        if ($image->getFormat() === $output) {
            return $image;
        }

        $input = $image->getFormat();

        $shift = $input->getBytesPerPixel();
        // size of image data (in bytes): WIDTH * HEIGHT * BYTES
        $length = $image->getWidth() * $image->getHeight() * $shift;

        // Input raw (bytes) data payload
        $idata  = $image->getContents();

        // Output raw (bytes) data payload
        $odata = '';

        for ($offset = 0; $offset < $length; $offset += $shift) {
            // Pixel in RGBA input
            $pixel = match ($input) {
                PixelFormat::R8G8B8 => $idata[$offset] . $idata[$offset + 1] . $idata[$offset + 2] . "\x00",
                PixelFormat::B8G8R8 => $idata[$offset + 2] . $idata[$offset + 1] . $idata[$offset] . "\x00",
                PixelFormat::R8G8B8A8 => $idata[$offset] . $idata[$offset + 1] . $idata[$offset + 2] . $idata[$offset + 3],
                PixelFormat::B8G8R8A8 => $idata[$offset + 2] . $idata[$offset + 1] . $idata[$offset] . $idata[$offset + 3],
                PixelFormat::A8B8G8R8 => $idata[$offset + 3] . $idata[$offset + 2] . $idata[$offset + 1] . $idata[$offset],
                default => throw new FormatException('Unsupported input format ' . $input->name),
            };

            // RGBA to output input
            $odata .= match ($output) {
                PixelFormat::R8G8B8 => $pixel[0] . $pixel[1] . $pixel[2],
                PixelFormat::B8G8R8 => $pixel[2] . $pixel[1] . $pixel[0],
                PixelFormat::R8G8B8A8 => $pixel,
                PixelFormat::B8G8R8A8 => $pixel[2] . $pixel[1] . $pixel[0] . $pixel[3],
                PixelFormat::A8B8G8R8 => $pixel[3] . $pixel[2] . $pixel[1] . $pixel[0],
            };
        }

        return new Image(
            format: $output,
            width: $image->getWidth(),
            height: $image->getHeight(),
            contents: $odata,
            compression: $image->getCompression(),
            metadata: $image->getMetadata(),
        );
    }
}
