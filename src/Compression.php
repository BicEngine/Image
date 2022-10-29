<?php

declare(strict_types=1);

namespace Bic\Image;

enum Compression implements CompressionInterface
{
    /**
     * Without compression.
     */
    case NONE;

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }
}
