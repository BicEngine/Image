<?php

declare(strict_types=1);

namespace Bic\Image;

use Bic\Binary\StreamInterface;
use Bic\Binary\TypedStream;

final class Reader
{
    /**
     * Read all data of the image as top-down algo.
     *
     * @param StreamInterface $stream Input image stream
     * @param positive-int $width Image width
     * @param positive-int $height Image height
     * @param positive-int $bytes Bytes count per line
     *
     * @return non-empty-string
     * @throws \Throwable
     */
    public static function topDown(TypedStream $stream, int $width, int $height, int $bytes): string
    {
        $result = '';

        foreach (self::lines($stream, $width, $height, $bytes) as $line) {
            $result .= $line;
        }

        return $result;
    }

    /**
     * Read all data of the image as bottom-up algo.
     *
     * @param StreamInterface $stream Input image stream
     * @param positive-int $width Image width
     * @param positive-int $height Image height
     * @param positive-int $bytes Bytes count per line
     *
     * @return non-empty-string
     * @throws \Throwable
     */
    public static function bottomUp(StreamInterface $stream, int $width, int $height, int $bytes): string
    {
        $result = '';

        foreach (self::lines($stream, $width, $height, $bytes) as $line) {
            $result = $line . $result;
        }

        return $result;
    }

    /**
     * Returns line of the image data.
     *
     * @param StreamInterface $stream Input image stream
     * @param positive-int $width Image width
     * @param positive-int $height Image height
     * @param positive-int $bytes Bytes count per line
     *
     * @return iterable<non-empty-string>
     * @throws \Throwable
     */
    public static function lines(StreamInterface $stream, int $width, int $height, int $bytes): iterable
    {
        $length = $bytes * $width;

        if (\Fiber::getCurrent()) {
            for ($y = 0, $lines = $height; $y < $lines; ++$y) {
                yield $chunk = $stream->read($length);
                \Fiber::suspend($chunk);
            }
        } else {
            for ($y = 0, $lines = $height; $y < $lines; ++$y) {
                yield $stream->read($length);
            }
        }
    }
}
