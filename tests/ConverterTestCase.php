<?php

declare(strict_types=1);

namespace Bic\Image\Tests;

use Bic\Image\PixelFormat;
use Bic\Image\Image;

class ConverterTestCase extends TestCase
{
    public function setUp(): void
    {
        foreach (PixelFormat::cases() as $format) {
            $pixel = match ($format) {
                PixelFormat::R8G8B8   => 'RGB',
                PixelFormat::B8G8R8   => 'BGR',
                PixelFormat::R8G8B8A8 => 'RGBA',
                PixelFormat::B8G8R8A8 => 'BGRA',
                PixelFormat::A8B8G8R8 => 'ABGR',
            };

            if (!\is_file($pathname = $this->pathname($format))) {
                \file_put_contents($pathname, \str_repeat($pixel, 10 * 10));
            }
        }

        parent::setUp();
    }

    private function read(PixelFormat $format): string
    {
        $pathname = $this->pathname($format);

        if (\is_file($pathname)) {
            return \file_get_contents($pathname);
        }

        return '';
    }

    private function pathname(PixelFormat $format): string
    {
        return __DIR__ . '/stubs/' . $format->name . '.bin';
    }

    public function formatsDataProvider(): array
    {
        $result = [];

        foreach (PixelFormat::cases() as $format) {
            $result[$format->name] = [$format];
        }

        return $result;
    }

    /**
     * @dataProvider formatsDataProvider
     */
    public function testConversion(PixelFormat $inputFormat): void
    {
        $input = new Image($inputFormat, 10, 10, $this->read($inputFormat));

        foreach (PixelFormat::cases() as $outputFormat) {
            $output = $this->converter->convert($input, $outputFormat);

            $expected = $this->read($outputFormat);
            $actual = $output->getContents();

            if ($inputFormat->getBytesPerPixel() !== $outputFormat->getBytesPerPixel()) {
                $expected = \str_replace('A', "\x00", $expected);
            }

            $this->assertSame($expected, $actual,
                'Invalid conversion from [' . $inputFormat->name . '] to [' . $outputFormat->name . ']',
            );
        }
    }
}
