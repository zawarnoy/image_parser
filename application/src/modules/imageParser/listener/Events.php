<?php

namespace Application\Src\Modules\ImageParser\Listener;

use Application\Src\Core\Application\ParseSite\ScriptParams;
use Application\Src\Core\Event\Event;
use Application\Src\Core\Event\EventData;
use Application\Src\Core\Event\EventListener;
use Application\Src\Modules\ImageParser\Service\Image\ImageDataSet;
use Application\Src\Modules\ImageParser\Service\Parser\SiteParser;
use Application\Src\Modules\ImageParser\Service\Uploader\ImagesToDesktopUploader;

class Events implements EventListener
{
    public function bindListeners()
    {
        Event::attach('parse.site',    new EventData(__CLASS__, 'onParseSite'));
        Event::attach('images.upload', new EventData(__CLASS__, 'onImagesUpload'));
    }

    /**
     * @param ScriptParams $params
     */
    public static function onParseSite($params)
    {
        $parser = new SiteParser($params->getUrl(), $params->getMaxImagesCount(), $params->getMaxPagesCount());
        $parser->parseSite();
        Event::trigger('images.upload', $parser->getImages());
    }

    /**
     * @param ImageDataSet $images
     */
    public static function onImagesUpload($images)
    {
        $uploader = new ImagesToDesktopUploader();
        $uploader->setPath('./images/');
        $uploader->upload($images);
    }
}