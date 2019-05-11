<?php

namespace Application\Src\Modules\ImageParser\Service\Link;


class LinkDataSet implements \Countable
{
    /** @var LinkData[] */
    protected $links;

    private $urlHost;

    function __construct($firstPageUrl)
    {
        $this->links = [];
        $this->urlHost = parse_url($firstPageUrl, PHP_URL_HOST);
    }

    /**
     * @param LinkData $linkData
     */
    public function addLink(LinkData $linkData)
    {
        $link = $linkData->getLink();

        if (!$this->isInDataSet($link) && $this->checkLinkBelongsToPage($link)) {
            $this->links[] = $linkData;
        }
    }

    /**
     * @param string $linkString
     * @return bool
     */
    protected function isInDataSet(string $linkString)
    {
        foreach ($this->links as $link) {
            if ($linkString === $link->getLink()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return LinkData[]|array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param LinkData|null $link
     */
    public function setVisited($link)
    {
        if (!$link) {
            return;
        }

        foreach ($this->links as $linkData) {
            if ($linkData->getLink() === $link->getLink()) {
                $linkData->setVisited(true);
                return;
            }
        }
    }

    /**
     * @return LinkData|null
     */
    public function getNextUnvisited()
    {
        foreach ($this->links as $link) {
            if (!$link->isVisited()) {
                return $link;
            }
        }

        return null;
    }

    public function getVisitedCount()
    {
        $links = array_filter($this->links, function ($link) {
            return $link->isVisited();
        });

        return count($links);
    }

    /**
     * @param $link
     * @return bool
     */
    protected function checkLinkBelongsToPage(string $link)
    {
        if (!preg_match('<https?://>', $link)) {
            return true;
        }

        if (!$parsedLink = parse_url($link, PHP_URL_HOST)) {
            return true;
        }

        return preg_match('<' . $this->urlHost . '>', $parsedLink) && $this->isValidLink($link);
    }

    /**
     * @param $link
     * @return mixed
     */
    protected function isValidLink(string $link)
    {
        return filter_var($link, FILTER_VALIDATE_URL);
    }

    public function count()
    {
        return count($this->links);
    }
}