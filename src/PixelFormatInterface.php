<?php

declare(strict_types=1);

namespace Bic\Image;

interface PixelFormatInterface
{
    /**
     * The number of significant bytes in a pixel value.
     *
     * @return positive-int
     */
    public function getBytesPerPixel(): int;

    /**
     * @param string $data
     * @param positive-int|0 $offset
     *
     * @return non-empty-string
     */
    public function toRGBA(string $data, int $offset = 0): string;

    /**
     * @param non-empty-string $data
     * @param positive-int|0 $offset
     *
     * @return string
     */
    public function fromRGBA(string $data, int $offset = 0): string;
}
