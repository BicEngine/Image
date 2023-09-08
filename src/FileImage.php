<?php

declare(strict_types=1);

namespace Bic\Image;

final class FileImage implements FileImageInterface
{
    /**
     * @psalm-taint-sink file $pathname
     * @param non-empty-string $pathname
     */
    public function __construct(
        private readonly string $pathname,
        private readonly ImageInterface $image,
    ) {
    }

    public function getMetadata(): object
    {
        return $this->image->getMetadata();
    }

    public function getFormat(): PixelFormatInterface
    {
        return $this->image->getFormat();
    }

    public function getCompression(): CompressionInterface
    {
        return $this->image->getCompression();
    }

    public function getWidth(): int
    {
        return $this->image->getWidth();
    }

    public function getHeight(): int
    {
        return $this->image->getHeight();
    }

    public function getContents(): string
    {
        return $this->image->getContents();
    }

    public function getBytes(): int
    {
        return $this->image->getBytes();
    }

    public function getPathname(): string
    {
        return $this->pathname;
    }
}
