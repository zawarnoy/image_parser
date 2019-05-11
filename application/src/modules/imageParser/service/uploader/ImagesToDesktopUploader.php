<?php

namespace Application\Src\Modules\ImageParser\Service\Uploader;

use Application\Src\Modules\ImageParser\Service\Image\ImageData;

class ImagesToDesktopUploader extends AbstractImagesUploader
{

    /** @var string */
    protected $path;

    public function setPath(string $path)
    {
        $this->path = $path;
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
    }

    protected function saveImage(ImageData $imageData)
    {
        $path = $this->path . time() . $imageData->getFileName();
        $this->downloadFile($imageData->getSource(), $path);
    }

    protected function downloadFile($url, $path)
    {
        if ($fp_remote = fopen($url, 'rb')) {
            $local_file = $path;
            if ($fp_local = fopen($local_file, 'wb')) {
                while ($buffer = fread($fp_remote, 8192)) {
                    fwrite($fp_local, $buffer);
                }
                fclose($fp_local);
            } else {
                fclose($fp_remote);
                return false;
            }

            fclose($fp_remote);
            return true;
        }
    }
}