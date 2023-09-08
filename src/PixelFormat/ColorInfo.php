<?php

declare(strict_types=1);

namespace Bic\Image\PixelFormat;

use Bic\Image\PixelFormat;

/**
 * @internal This is an internal class, please do not use it in your application code.
 * @psalm-internal Bic\Image\PixelFormat
 */
final class ColorInfo implements ColorInfoInterface
{
    /**
     * @var int<0, 4294967295>
     */
    public readonly int $offset;

    /**
     * @var int<0, 4294967295>
     */
    public readonly int $loss;

    public function __construct(
        public readonly int $mask = 0x00_00_00_00,
        int|null $offset = null,
        int|null $loss = null,
    ) {
        $this->offset = $offset ?? PixelFormat::getOffsetByMask($this->mask);
        $this->loss = $loss ?? PixelFormat::getLossByMask($this->mask);
    }

    public function getMask(): int
    {
        return $this->mask;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLoss(): int
    {
        return $this->loss;
    }
}
