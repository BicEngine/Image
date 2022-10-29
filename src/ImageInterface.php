<?php

declare(strict_types=1);

namespace Bic\Image;

interface ImageInterface
{
    /**
     * Returns additional image metadata.
     *
     * @return object
     */
    public function getMetadata(): object;

    /**
     * Returns image's pixel format.
     *
     * @return PixelFormatInterface
     */
    public function getFormat(): PixelFormatInterface;

    /**
     * Returns image compression.
     *
     * @return CompressionInterface
     */
    public function getCompression(): CompressionInterface;

    /**
     * Returns image width (in pixels).
     *
     * @psalm-return positive-int
     */
    public function getWidth(): int;

    /**
     * Returns image height (in pixels).
     *
     * @psalm-return positive-int
     */
    public function getHeight(): int;

    /**
     * Returns pixels data as binary string.
     *
     * @return non-empty-string
     */
    public function getContents(): string;

    /**
     * Returns size in bytes.
     *
     * @return positive-int
     */
    public function getBytes(): int;
}
