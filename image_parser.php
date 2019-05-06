<?php

use Application\Src\Core\Application\ParseSiteApplication;
use Application\Src\Core\Loader\Modules\ModulesLoaderFromArray;

require_once('application/autoload.php');

$app = new ParseSiteApplication();
$app->setLoader(new ModulesLoaderFromArray());

try {
    $app->run();
} catch (Exception $e) {
}

