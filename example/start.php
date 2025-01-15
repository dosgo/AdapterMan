<?php
use Adapterman\Adapterman;
use Adapterman\Http;
use Workerman\Worker;
use Workerman\Timer;

define('WEB_ROOT',"/cygdrive/d/www/ninekedev/webapp/web/nineke/");

require_once __DIR__.'/workerman/Autoloader.php';
require_once 'autoload.php';
Adapterman::init();

require __DIR__ . '/../src/frameworks/comm.php';

$http_worker = new Worker('http://0.0.0.0:8087');
$http_worker->count = cpu_count() * 4;
$http_worker->name = 'AdapterMan';

$http_worker->onWorkerStart = function (Worker $worker) {
    if ($worker->id === 0) {
        Timer::add(600, function(){
            Http::tryGcSessions();
        });
    }
};

$http_worker->onMessage = static function ($connection, $request) {
    $connection->send(run());
};

Worker::runAll();
