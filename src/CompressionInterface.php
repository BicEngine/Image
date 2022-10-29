<?php

declare(strict_types=1);

namespace Bic\Image;

interface CompressionInterface
{
    /**
     * Compression short name.
     *
     * @return non-empty-string
     */
    public function getName(): string;
}
