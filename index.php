<?php

declare(strict_types=1);

namespace TeamRanked;

require_once 'vendor/autoload.php';

use Pimple\Container;
use TeamRanked\providers\UrlDataProvider;
use TeamRanked\readers\JsonReader;
use TeamRanked\handlers\SportDataHandler;
use TeamRanked\renders\JsonRender;

$container = new Container();

$container['teamRanked.source'] = $_REQUEST['endpoint'] ?? null;

$container['teamRanked.dataProvider'] = function ($c) {
    return new UrlDataProvider($c['teamRanked.source']);
};

$container['teamRanked.parser'] = function () {
    return new JsonReader();
};

$container['teamRanked.handler'] = function () {
    return new SportDataHandler();
};

$container['teamRanked.render'] = function () {
    return new JsonRender();
};

$container['teamRanked.teamRanked'] = function ($c) {
    return new TeamRanked($c['teamRanked.dataProvider'], $c['teamRanked.parser'], $c['teamRanked.handler'], $c['teamRanked.render']);
};

$container['teamRanked.teamRanked']->init();
echo $container['teamRanked.teamRanked']->getRenderedData();