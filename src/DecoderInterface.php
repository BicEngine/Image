<?php

declare(strict_types=1);

namespace Bic\Image;

interface DecoderInterface
{
    /**
     * @param resource $stream
     *
     * @return iterable<ImageInterface>|null
     */
    public function decode(mixed $stream): ?iterable;
}
