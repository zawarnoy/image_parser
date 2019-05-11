<?php

namespace Application\Src\Modules\ImageParser\Service\Link;

use Application\Src\Modules\ImageParser\Service\Facility\IsAbsoluteLinkTrait;

class LinkData
{
    use IsAbsoluteLinkTrait;

    protected $link;
    protected $visited;

    function __construct($link, $visited = false)
    {
        $this->link = $link;
        $this->visited = $visited;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return bool
     */
    public function isVisited(): bool
    {
        return $this->visited;
    }

    /**
     * @param bool $visited
     */
    public function setVisited(bool $visited)
    {
        $this->visited = $visited;
    }
}