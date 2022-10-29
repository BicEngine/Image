<?php

declare(strict_types=1);

namespace Bic\Image;

use Bic\Image\Exception\CompressionException;

final class Converter implements ConverterInterface
{
    /**
     * {@inheritDoc}
     */
    public function convert(ImageInterface $image, PixelFormatInterface $output): ImageInterface
    {
        if ($image->getCompression() !== Compression::NONE) {
            throw CompressionException::fromExpectedNonCompressed($image->getCompression());
        }

        if ($image->getFormat() === $output) {
            return $image;
        }

        $input = $image->getFormat();

        $shift = $input->getBytesPerPixel();
        // size of image data (in bytes): WIDTH * HEIGHT * BYTES
        $length = $image->getWidth() * $image->getHeight() * $shift;

        // Input raw (bytes) data payload
        $idata = $image->getContents();

        /**
         * Output raw (bytes) data payload
         *
         * @var non-empty-string $odata
         */
        $odata = '';

        for ($offset = 0; $offset < $length; $offset += $shift) {
            $odata .= $output->fromRGBA(
                $input->toRGBA($idata, $offset)
            );
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
