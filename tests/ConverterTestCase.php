<?php

declare(strict_types=1);

namespace Bic\Image\Tests;

use Bic\Image\Format;
use Bic\Image\Image;

class ConverterTestCase extends TestCase
{
    public function setUp(): void
    {
        foreach (Format::cases() as $format) {
            $pixel = match ($format) {
                Format::R8G8B8   => 'RGB',
                Format::B8G8R8   => 'BGR',
                Format::R8G8B8A8 => 'RGBA',
                Format::B8G8R8A8 => 'BGRA',
                Format::A8B8G8R8 => 'ABGR',
            };

            if (!\is_file($pathname = $this->pathname($format))) {
                \file_put_contents($pathname, \str_repeat($pixel, 10 * 10));
            }
        }

        parent::setUp();
    }

    private function read(Format $format): string
    {
        $pathname = $this->pathname($format);

        if (\is_file($pathname)) {
            return \file_get_contents($pathname);
        }

        return '';
    }

    private function pathname(Format $format): string
    {
        return __DIR__ . '/stubs/' . $format->name . '.bin';
    }

    public function formatsDataProvider(): array
    {
        $result = [];

        foreach (Format::cases() as $format) {
            $result[$format->name] = [$format];
        }

        return $result;
    }

    /**
     * @dataProvider formatsDataProvider
     */
    public function testConversion(Format $inputFormat): void
    {
        $input = new Image($inputFormat, 10, 10, $this->read($inputFormat));

        foreach (Format::cases() as $outputFormat) {
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
