<?php

declare(strict_types=1);

namespace Bic\Image;

interface ConverterInterface
{
    /**
     * @param ImageInterface $image
     * @param PixelFormat $output
     *
     * @return ImageInterface
     */
    public function convert(ImageInterface $image, PixelFormat $output): ImageInterface;
}
