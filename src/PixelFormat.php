<?php

declare(strict_types=1);

namespace Bic\Image;

use Bic\Image\Exception\FormatException;
use Bic\Image\Format\Info;

enum PixelFormat implements PixelFormatInterface
{
    #[Info(size: 3)]
    case R8G8B8;

    #[Info(size: 3)]
    case B8G8R8;

    #[Info(size: 4)]
    case R8G8B8A8;

    #[Info(size: 4)]
    case B8G8R8A8;

    #[Info(size: 4)]
    case A8B8G8R8;

    /**
     * @return Info
     *
     * @psalm-suppress all - psalm bug
     */
    private function getInfo(): Info
    {
        /** @var \WeakMap<PixelFormat, Info>|null $attributes */
        static $attributes = null;

        $attributes ??= new \WeakMap();

        if (!isset($attributes[$this])) {
            $reflection = new \ReflectionEnumUnitCase($this, $this->name);

            foreach ($reflection->getAttributes(Info::class) as $attribute) {
                return $attributes[$this] = $attribute->newInstance();
            }
        }

        /** @psalm-var Info */
        return $attributes[$this] ??= new Info();
    }

    /**
     * {@inheritDoc}
     */
    public function getBytesPerPixel(): int
    {
        $info = $this->getInfo();

        return $info->size;
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificReturnType
     * @psalm-suppress LessSpecificReturnStatement
     */
    public function toRGBA(string $data, int $offset = 0): string
    {
        return match ($this) {
            PixelFormat::R8G8B8   => ($data[$offset] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset + 2] ?? "\x00")
                . "\x00",
            PixelFormat::B8G8R8   => ($data[$offset + 2] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset] ?? "\x00")
                . "\x00",
            PixelFormat::R8G8B8A8 => ($data[$offset] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset + 2] ?? "\x00")
                . ($data[$offset + 3] ?? "\x00"),
            PixelFormat::B8G8R8A8 => ($data[$offset + 2] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset] ?? "\x00")
                . ($data[$offset + 3] ?? "\x00"),
            PixelFormat::A8B8G8R8 => ($data[$offset + 3] ?? "\x00")
                . ($data[$offset + 2] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset] ?? "\x00"),
            default => throw new FormatException('Unsupported input format ' . $this->name),
        };
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificReturnType
     * @psalm-suppress LessSpecificReturnStatement
     */
    public function fromRGBA(string $data, int $offset = 0): string
    {
        return match ($this) {
            PixelFormat::R8G8B8   => ($data[$offset] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset + 2] ?? "\x00"),
            PixelFormat::B8G8R8   => ($data[$offset + 2] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset] ?? "\x00"),
            PixelFormat::R8G8B8A8 => ($data[$offset] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset + 2] ?? "\x00") .
                ($data[$offset + 3] ?? "\x00"),
            PixelFormat::B8G8R8A8 => ($data[$offset + 2] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset] ?? "\x00")
                . ($data[$offset + 3] ?? "\x00"),
            PixelFormat::A8B8G8R8 => ($data[$offset + 3] ?? "\x00")
                . ($data[$offset + 2] ?? "\x00")
                . ($data[$offset + 1] ?? "\x00")
                . ($data[$offset] ?? "\x00"),
            default => throw new FormatException('Unsupported input format ' . $this->name),
        };
    }
}
