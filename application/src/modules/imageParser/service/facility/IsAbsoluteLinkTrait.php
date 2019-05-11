<?php

namespace Application\Src\Modules\ImageParser\Service\Facility;

trait IsAbsoluteLinkTrait
{
    /**
     * @param $link
     * @return false|int
     */
    public function isAbsolute($link)
    {
        return preg_match( '<https?://>', $link);
    }

}