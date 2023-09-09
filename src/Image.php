<?php

declare(strict_types=1);

namespace Bic\Image;

final class Image implements ImageInterface
{
    /**
     * @var int<1, max>|null
     */
    private ?int $bytes = null;

    /**
     * @param int<1, max> $width
     * @param int<1, max> $height
     * @param non-empty-string $data
     */
    public function __construct(
        private readonly PixelFormatInterface $format,
        private readonly int $width,
        private readonly int $height,
        private readonly string $data,
        private readonly CompressionInterface $compression = Compression::NONE,
        private readonly ?object $metadata = null,
    ) {
    }

    public function getMetadata(): ?object
    {
        return $this->metadata;
    }

    public function getFormat(): PixelFormatInterface
    {
        return $this->format;
    }

    public function getCompression(): CompressionInterface
    {
        return $this->compression;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getBytes(): int
    {
        if ($this->bytes !== null) {
            return $this->bytes;
        }

        if ($this->compression === Compression::NONE) {
            return $this->bytes = $this->width * $this->height * $this->format->getBytesPerPixel();
        }

        return $this->bytes = \strlen($this->data);
    }
}
