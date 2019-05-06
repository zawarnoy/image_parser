<?php

namespace Application\Src\Core\Loader\Modules;

use Application\Src\Core\Loader\ModulesInfo\InfoInfoLoaderFromFile;

class ModulesLoaderFromArray extends AbstractModulesLoader
{

    public function __construct()
    {
        $this->infoLoader = new InfoInfoLoaderFromFile();
    }

    public function loadModules()
    {
        $modulesInfo = $this->infoLoader->loadModulesInfo();

        foreach ($modulesInfo as $name => $value) {
            if ($value) {
                $this->loadModule($name);
            }
        }
    }
}