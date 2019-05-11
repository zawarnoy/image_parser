<?php

namespace Application\Src\Core\Application\ParseSite;

use InvalidArgumentException;

class ScriptParams
{

    protected $url;
    protected $maxImagesCount;
    protected $maxPagesCount;

    CONST MAX_IMAGES_COUNT = 10;
    CONST MAX_PAGES_COUNT = 5;

    /**
     * ScriptParams constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        if (isset($params[1])) {
            $this->url = $params[1];
            $this->maxImagesCount = $params[2] ?? self::MAX_IMAGES_COUNT;
            $this->maxPagesCount = $params[3] ?? self::MAX_PAGES_COUNT;
        } else {
            throw new InvalidArgumentException('Parameters should have at least one element!');
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getMaxImagesCount()
    {
        return $this->maxImagesCount;
    }

    /**
     * @return string
     */
    public function getMaxPagesCount()
    {
        return $this->maxPagesCount;
    }
}