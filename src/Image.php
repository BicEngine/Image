<?php

declare(strict_types=1);

namespace Bic\Image;

final class Image implements ImageInterface
{
    /**
     * @param positive-int $width
     * @param positive-int $height
     * @param non-empty-string $contents
     */
    public function __construct(
        protected readonly PixelFormatInterface $format,
        protected readonly int $width,
        protected readonly int $height,
        protected readonly string $contents,
        protected readonly CompressionInterface $compression = Compression::NONE,
        protected readonly object $metadata = new \stdClass(),
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getMetadata(): object
    {
        return $this->metadata;
    }

    /**
     * {@inheritDoc}
     */
    public function getFormat(): PixelFormatInterface
    {
        return $this->format;
    }

    /**
     * {@inheritDoc}
     */
    public function getCompression(): CompressionInterface
    {
        return $this->compression;
    }

    /**
     * {@inheritDoc}
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * {@inheritDoc}
     */
    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * {@inheritDoc}
     */
    public function getBytes(): int
    {
        return $this->width * $this->height * $this->format->getBytesPerPixel();
    }
}
