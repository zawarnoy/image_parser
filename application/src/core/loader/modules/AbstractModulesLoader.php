<?php

namespace Application\Src\Core\Loader\Modules;

use Application\Src\Core\Event\EventListener;
use Application\Src\Core\Loader\ModulesInfo\InfoLoader;

abstract class AbstractModulesLoader implements ModulesLoader
{
    /** @var InfoLoader */
    protected $infoLoader;

    protected $modulesPath = './application/src/modules';

    protected $eventsPath = '/listener/Events.php';

    protected function loadModule($moduleName)
    {
        $className = $this->getClassNameFromFile($this->getPathToFileFromModuleName($moduleName));

        if ($className && ($eventListener = new $className()) && $eventListener instanceof EventListener) {
            $eventListener->bindListeners();
        }
    }

    protected function getClassNameFromFile($path_to_file)
    {
        $contents = file_get_contents($path_to_file);
        $namespace = $class = "";
        $getting_namespace = $getting_class = false;

        foreach (token_get_all($contents) as $token) {
            if (is_array($token) && $token[0] == T_NAMESPACE) {
                $getting_namespace = true;
            }

            if (is_array($token) && $token[0] == T_CLASS) {
                $getting_class = true;
            }

            if ($getting_namespace === true) {
                if (is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR])) {
                    $namespace .= $token[1];
                } else if ($token === ';') {
                    $getting_namespace = false;
                }
            }

            if ($getting_class === true) {
                if (is_array($token) && $token[0] == T_STRING) {
                    $class = $token[1];
                    break;
                }
            }
        }

        return $namespace ? $namespace . '\\' . $class : $class;
    }

    protected function getPathToFileFromModuleName($moduleName)
    {
        return realpath($this->modulesPath . '/' . $moduleName . '/' . $this->eventsPath);
    }
}