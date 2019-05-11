<?php

namespace Application\Src\Modules\ImageParser\Service\Image;


use Application\Src\Modules\ImageParser\Service\Facility\IsAbsoluteLinkTrait;

class ImageData
{
    use IsAbsoluteLinkTrait;

    protected $source;

    function __construct(string $source, $link)
    {
        if ($this->isAbsolute($source)) {
            $this->source = $source;
        } else {
            $parsedUrl = parse_url($link);
            $this->source = $parsedUrl['scheme'] . "://" . $parsedUrl['host'] . $source;
        }
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    public function getFileName()
    {
        return preg_replace('<^.*/>', '', $this->source);
    }
}