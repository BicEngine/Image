<?php

declare(strict_types=1);

namespace Bic\Image\Tests;

use Bic\Image\Converter;
use Bic\Image\ConverterInterface;
use Bic\Image\Format;
use Bic\Image\Image;
use Bic\Image\ImageInterface;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected readonly ConverterInterface $converter;

    public function setUp(): void
    {
        $this->converter = new Converter();

        parent::setUp();
    }

    protected function image(Format $format, int $p1, int $p2, int $p3, int $p4 = null): ?ImageInterface
    {
        $pixel = $p4 === null
            ? $this->pack8($p1, $p2, $p3)
            : $this->pack8($p1, $p2, $p3, $p4);

        $width = $height = 10;

        $pixels = '';

        for ($i = $width * $height; $i > 0; --$i) {
            $pixels .= $pixel;
        }

        return new Image($format, $width, $height, $pixels);
    }

    protected function pack8(int ...$bytes): string
    {
        $result = '';

        foreach ($bytes as $byte) {
            $result .= \chr($byte);
        }

        return $result;
    }
}
