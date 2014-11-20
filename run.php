#!/usr/bin/hhvm
<?php

use React\EventLoop\Factory;
use React\Socket\Server;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__.'/bootstrap/paths.php';
require __DIR__. '/bootstrap/autoload.php';
require __DIR__. '/bootstrap/start.php';

global $conn;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'mud',
    'username'  => 'root',
    'password'  => 'insight21',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();


define("SERVER_IP", "0.0.0.0");
define("SERVER_PORT", 4444);

$loop   = Factory::create();
$webSock = new Server($loop);
$conn = new Connection();
$webSock->listen(SERVER_PORT, SERVER_IP); // Binding to 0.0.0.0 means remotes can connect
$webServer = new IoServer( new HttpServer( new WsServer($conn)), $webSock);
$loop->run();
