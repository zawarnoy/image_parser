<?php

namespace Application\Src\Core\Application;

use Application\Src\Core\Event\Event;

class ParseSiteApplication extends Application
{
    protected $params;

    /**
     * @throws \Exception
     */
    public function run()
    {
        parent::run();

        if (!$this->params) {
            throw new \Exception('Empty parameters');
        }

        Event::trigger('parse.site', $this->params);
    }

    public function setParams($params)
    {
        $this->params = $params;
    }
}