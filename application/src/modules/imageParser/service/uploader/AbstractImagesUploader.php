<?php

namespace Application\Src\Modules\ImageParser\Service\Uploader;

use Application\Src\Modules\ImageParser\Service\Image\ImageData;
use Application\Src\Modules\ImageParser\Service\Image\ImageDataSet;

abstract class AbstractImagesUploader implements ImagesUploader
{
    public function upload(ImageDataSet $pictures)
    {
        foreach ($pictures as $picture) {
            $this->saveImage($picture);
        }
    }

    protected abstract function saveImage(ImageData $image);
}