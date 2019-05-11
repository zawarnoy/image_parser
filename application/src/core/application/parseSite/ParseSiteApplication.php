<?php

namespace Application\Src\Core\Application\ParseSite;

use Application\Src\Core\Application\Application;
use Application\Src\Core\Event\Event;

class ParseSiteApplication extends Application
{
    /** @var \ArrayObject */
    protected $params;

    /**
     * @throws \Exception
     */
    public function run()
    {
        parent::run();
        Event::trigger('parse.site', $this->params);
    }

    public function setParams(array $params)
    {
        $this->params = new ScriptParams($params);
    }
}