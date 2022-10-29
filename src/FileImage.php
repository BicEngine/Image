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
        private readonly ImageInterface $icon,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getMetadata(): object
    {
        return $this->icon->getMetadata();
    }

    /**
     * {@inheritDoc}
     */
    public function getFormat(): PixelFormatInterface
    {
        return $this->icon->getFormat();
    }

    /**
     * {@inheritDoc}
     */
    public function getCompression(): CompressionInterface
    {
        return $this->icon->getCompression();
    }

    /**
     * {@inheritDoc}
     */
    public function getWidth(): int
    {
        return $this->icon->getWidth();
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight(): int
    {
        return $this->icon->getHeight();
    }

    /**
     * {@inheritDoc}
     */
    public function getContents(): string
    {
        return $this->icon->getContents();
    }

    /**
     * {@inheritDoc}
     */
    public function getBytes(): int
    {
        return $this->icon->getBytes();
    }

    /**
     * {@inheritDoc}
     */
    public function getPathname(): string
    {
        return $this->pathname;
    }
}
