<?php

declare(strict_types=1);

namespace Bic\Image;

use Bic\Image\PixelFormat\ColorInfoInterface;
use Bic\Image\PixelFormat\Info;

final class UserPixelFormat extends Info implements PixelFormatInterface
{
    public function getBytesPerPixel(): int
    {
        return $this->bytes;
    }

    public function getRedColor(): ColorInfoInterface
    {
        return $this->red;
    }

    public function getGreenColor(): ColorInfoInterface
    {
        return $this->green;
    }

    public function getBlueColor(): ColorInfoInterface
    {
        return $this->blue;
    }

    public function getAlphaColor(): ColorInfoInterface
    {
        return $this->alpha;
    }
}
