<?php

namespace Application\Src\Modules\ImageParser\Service\Parser;

use Application\Src\Core\Event\Event;
use Application\Src\Modules\ImageParser\Service\Image\ImageData;
use Application\Src\Modules\ImageParser\Service\Image\ImageDataSet;
use Application\Src\Modules\ImageParser\Service\Link\LinkData;
use Application\Src\Modules\ImageParser\Service\Link\LinkDataSet;
use GuzzleHttp\Client;

class SiteParser
{

    protected $maxImagesCount;
    protected $maxPagesCount;
    protected $links;
    protected $firstPageUrl;
    protected $images;

    /** @var Client */
    protected $client;

    public function __construct($url, $maxImagesCount, $maxPagesCount)
    {
        $this->firstPageUrl = $url;
        $this->maxImagesCount = $maxImagesCount;
        $this->maxPagesCount = $maxPagesCount;
        $this->client = $this->client = new Client(['verify' => false]);
        $this->links = new LinkDataSet($this->firstPageUrl);
        $this->links->addLink(new LinkData($this->firstPageUrl, true));
        $this->images = new ImageDataSet();
    }

    public function parseSite(LinkData $linkData = null)
    {
        $link = $this->handleLinkForParse($linkData);
        $response = $this->client->request('GET', $link);

        $this->links->setVisited($linkData);

        $document = new \DOMDocument();
        @$document->loadHTML($response->getBody()->getContents());

        $this->handleImagesFromPage($document, $link);
        $this->handleLinksFromPage($document);

        $this->parseNext();
    }

    /**
     * @param LinkData|null $linkData
     * @return string
     */
    protected function handleLinkForParse($linkData)
    {
        if ($linkData === null) {
            return $this->firstPageUrl;
        }

        if ($linkData->isAbsolute($linkData->getLink())) {
            return $linkData->getLink();
        }

        $urlData = parse_url($this->firstPageUrl);
        return $urlData['scheme'] . "://" . $urlData['host'] . $linkData->getLink();
    }

    /**
     * @param \DOMDocument $document
     * @param string $link
     */
    protected function handleImagesFromPage(\DOMDocument $document, $link)
    {
        /** @var \DOMElement $element */
        foreach ($document->getElementsByTagName('img') as $element) {
            if (count($this->images) > $this->maxImagesCount) {
                return;
            }

            $this->images->addImageData(new ImageData($element->getAttribute('src'), $link));
        }
    }

    protected function handleLinksFromPage(\DOMDocument $document)
    {
        /** @var \DOMElement $element */
        foreach ($document->getElementsByTagName('a') as $element) {
            if (count($this->links) > $this->maxPagesCount) {
                return;
            }

            $this->links->addLink(new LinkData($element->getAttribute('href')));
        }
    }

    private function parseNext()
    {
        $nextLink = $this->links->getNextUnvisited();

        if ($nextLink && count($this->images) < $this->maxImagesCount && $this->links->getVisitedCount() < $this->maxPagesCount) {
            $this->parseSite($nextLink);
        }
    }

    /**
     * @return ImageDataSet
     */
    public function getImages(): ImageDataSet
    {
        return $this->images;
    }
}