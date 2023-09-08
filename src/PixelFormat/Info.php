<?php

declare(strict_types=1);

namespace Bic\Image\PixelFormat;

/**
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal Bic\Image
 */
#[\Attribute(\Attribute::TARGET_CLASS_CONSTANT)]
final class Info
{
    /**
     * @param int<1, max> $bytes
     */
    public function __construct(
        public readonly int $bytes = 1,
        public readonly ColorInfo $red = new ColorInfo(),
        public readonly ColorInfo $green = new ColorInfo(),
        public readonly ColorInfo $blue = new ColorInfo(),
        public readonly ColorInfo $alpha = new ColorInfo(),
    ) {
    }
}
