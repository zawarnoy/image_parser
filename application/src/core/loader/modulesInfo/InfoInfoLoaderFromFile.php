<?php

namespace Application\Src\Core\Loader\ModulesInfo;

class InfoInfoLoaderFromFile implements InfoLoader
{
    protected $file;

    /**
     * InfoInfoLoaderFromFile constructor.
     * @param string $file
     *
     * File - path to modules ini file.
     */
    public function __construct($file = './application/src/modules/modules.ini')
    {
        $this->file = $file;
    }

    public function loadModulesInfo()
    {
        @$modules = parse_ini_file($this->file);

        if (!$modules) {
            return [];
        }

        return $modules;
    }
}