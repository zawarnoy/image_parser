<?php

use Application\Src\Core\Application\ParseSite\ParseSiteApplication;
use Application\Src\Core\Loader\Modules\ModulesLoaderFromArray;

require_once('application/autoload.php');

$app = new ParseSiteApplication();
$app->setLoader(new ModulesLoaderFromArray());
$app->setParams($argv);

try {
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}

