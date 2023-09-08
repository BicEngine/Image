<?php

declare(strict_types=1);

namespace Bic\Image;

use Bic\Image\PixelFormat\ColorInfoInterface;

interface PixelFormatInterface
{
    /**
     * The number of significant bytes in a pixel value.
     *
     * @return int<1, 4> Expects [ int8 ... int32 ] range.
     */
    public function getBytesPerPixel(): int;

    /**
     * Returns information about red pixels format.
     */
    public function getRedColor(): ColorInfoInterface;

    /**
     * Returns information about green pixels format.
     */
    public function getGreenColor(): ColorInfoInterface;

    /**
     * Returns information about blue pixels format.
     */
    public function getBlueColor(): ColorInfoInterface;

    /**
     * Returns information about alpha pixels format.
     */
    public function getAlphaColor(): ColorInfoInterface;
}
