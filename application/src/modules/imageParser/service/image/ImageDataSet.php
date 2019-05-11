<?php

namespace Application\Src\Modules\ImageParser\Service\Image;

class ImageDataSet implements \Countable, \Iterator
{

    /**
     * @var ImageData[]
     */
    protected $images;

    /**
     * ImageDataSet constructor.
     */
    function __construct()
    {
        $this->images = [];
    }

    /**
     * @param ImageData $imageData
     */
    public function addImageData(ImageData $imageData)
    {
        foreach ($this as $image) {
            if ($image->getSource() === $imageData->getSource()) {
                return;
            }
        }

        $this->images[] = $imageData;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    public function count()
    {
        return count($this->images);
    }

    public function current()
    {
        return current($this->images);
    }

    public function next()
    {
        return next($this->images);
    }


    public function key()
    {
        return key($this->images);
    }

    public function valid()
    {
        $key = key($this->images);
        return $key !== NULL && $key !== FALSE;
    }

    public function rewind()
    {
        reset($this->images);
    }
}