<?php

namespace Application\Src\Core\Application;

use Application\Src\Core\Event\Event;
use Application\Src\Core\Loader\Modules\ModulesLoader;

class Application
{
    /**
     * @var ModulesLoader
     */
    protected $modulesLoader;

    public function __construct()
    {
    }

    public function run()
    {
        $this->modulesLoader->loadModules();
        Event::trigger('application.run', null);
    }

    /**
     * @param ModulesLoader $loader
     */
    public function setLoader(ModulesLoader $loader)
    {
        $this->modulesLoader = $loader;
    }

}