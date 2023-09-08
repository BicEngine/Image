<?php

declare(strict_types=1);

namespace Bic\Image\PixelFormat;

interface ColorInfoInterface
{
    /**
     * @return int<0, 4294967295>
     */
    public function getMask(): int;

    /**
     * @return int<0, 4294967295>
     */
    public function getOffset(): int;

    /**
     * @return int<0, 4294967295>
     */
    public function getLoss(): int;
}
