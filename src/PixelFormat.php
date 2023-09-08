<?php

declare(strict_types=1);

namespace Bic\Image;

use Bic\Image\PixelFormat\ColorInfo;
use Bic\Image\PixelFormat\Info;

enum PixelFormat implements PixelFormatInterface
{
    #[Info(
        bytes: 3,
        red:   new ColorInfo(0b11111111_00000000_00000000_00000000),
        green: new ColorInfo(0b00000000_11111111_00000000_00000000),
        blue:  new ColorInfo(0b00000000_00000000_11111111_00000000),
    )]
    case R8G8B8;

    #[Info(
        bytes: 3,
        red:   new ColorInfo(0b00000000_00000000_11111111_00000000),
        green: new ColorInfo(0b00000000_11111111_00000000_00000000),
        blue:  new ColorInfo(0b11111111_00000000_00000000_00000000),
    )]
    case B8G8R8;

    #[Info(
        bytes: 4,
        red:   new ColorInfo(0b11111111_00000000_00000000_00000000),
        green: new ColorInfo(0b00000000_11111111_00000000_00000000),
        blue:  new ColorInfo(0b00000000_00000000_11111111_00000000),
        alpha: new ColorInfo(0b00000000_00000000_00000000_11111111),
    )]
    case R8G8B8A8;

    #[Info(
        bytes: 4,
        red:   new ColorInfo(0b00000000_00000000_11111111_00000000),
        green: new ColorInfo(0b00000000_11111111_00000000_00000000),
        blue:  new ColorInfo(0b11111111_00000000_00000000_00000000),
        alpha: new ColorInfo(0b00000000_00000000_00000000_11111111),
    )]
    case B8G8R8A8;

    #[Info(
        bytes: 4,
        red:   new ColorInfo(0b00000000_00000000_00000000_11111111),
        green: new ColorInfo(0b00000000_00000000_11111111_00000000),
        blue:  new ColorInfo(0b00000000_11111111_00000000_00000000),
        alpha: new ColorInfo(0b11111111_00000000_00000000_00000000),
    )]
    case A8B8G8R8;

    private function getInfo(): Info
    {
        /**
         * Local identity map for Info metadata objects.
         *
         * @var array<non-empty-string, Info> $memory
         */
        static $memory = [];

        if (isset($memory[$this->name])) {
            return $memory[$this->name];
        }

        $attributes = (new \ReflectionEnumUnitCase(self::class, $this->name))
            ->getAttributes(Info::class)
        ;

        if (isset($attributes[0])) {
            return $memory[$this->name] = $attributes[0]->newInstance();
        }

        throw new \LogicException('Could not load pixel format [' . $this->name . '] info');
    }

    public function getBytesPerPixel(): int
    {
        $info = $this->getInfo();

        return $info->bytes;
    }

    /**
     * @param int<0, max> $mask
     *
     * @return int<0, max>
     */
    public static function getOffsetByMask(int $mask): int
    {
        if ($mask === 0) {
            return 0;
        }

        $offset = 0;

        for (; !($mask & 0x01); $mask >>= 1) {
            ++$offset;
        }

        return $offset;
    }

    /**
     * @param int<0, max> $mask
     *
     * @return int<0, max>
     */
    public static function getLossByMask(int $mask): int
    {
        if ($mask === 0) {
            return 0;
        }

        $loss = 0;
        for (; ($mask & 0x01); $mask >>= 1) {
            ++$loss;
        }

        return $loss;
    }

    public function getRedColor(): ColorInfo
    {
        $info = $this->getInfo();

        return $info->red;
    }

    public function getGreenColor(): ColorInfo
    {
        $info = $this->getInfo();

        return $info->green;
    }

    public function getBlueColor(): ColorInfo
    {
        $info = $this->getInfo();

        return $info->blue;
    }

    public function getAlphaColor(): ColorInfo
    {
        $info = $this->getInfo();

        return $info->alpha;
    }
}
