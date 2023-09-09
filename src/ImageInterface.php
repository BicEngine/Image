<?php

declare(strict_types=1);

namespace Bic\Image;

interface ImageInterface
{
    /**
     * Returns additional image metadata.
     *
     * @return object|null
     */
    public function getMetadata(): ?object;

    /**
     * Returns image's pixel format.
     */
    public function getFormat(): PixelFormatInterface;

    /**
     * Returns image compression.
     */
    public function getCompression(): CompressionInterface;

    /**
     * Returns image width (in pixels).
     *
     * @return int<1, max>
     */
    public function getWidth(): int;

    /**
     * Returns image height (in pixels).
     *
     * @return int<1, max>
     */
    public function getHeight(): int;

    /**
     * Returns pixels data as binary string.
     *
     * @return non-empty-string
     */
    public function getData(): string;

    /**
     * Returns size in bytes.
     *
     * @return int<1, max>
     */
    public function getBytes(): int;
}
