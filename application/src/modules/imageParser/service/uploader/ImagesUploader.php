<?php

namespace Application\Src\Modules\ImageParser\Service\Uploader;

use Application\Src\Modules\ImageParser\Service\Image\ImageDataSet;

interface ImagesUploader
{
    public function upload(ImageDataSet $images);
}