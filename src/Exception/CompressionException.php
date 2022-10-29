<?php

declare(strict_types=1);

namespace Bic\Image\Exception;

use Bic\Image\CompressionInterface;

class CompressionException extends ImageException
{
    /**
     * @param CompressionInterface $compression
     *
     * @return static
     */
    public static function fromExpectedNonCompressed(CompressionInterface $compression): self
    {
        $message = \vsprintf('Could not convert %s compressed image, please decompress it first', [
            $compression->getName(),
        ]);

        return new static($message);
    }
}
