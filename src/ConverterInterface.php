<?php

declare(strict_types=1);

namespace Bic\Image;

interface ConverterInterface
{
    /**
     * @param ImageInterface $image
     * @param PixelFormatInterface $output
     *
     * @return ImageInterface
     */
    public function convert(ImageInterface $image, PixelFormatInterface $output): ImageInterface;
}
