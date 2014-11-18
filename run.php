#!/usr/bin/hhvm
<?php

use React\EventLoop\Factory;
use React\Socket\Server;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require __DIR__.'/bootstrap/paths.php';
require __DIR__. '/bootstrap/autoload.php';
require __DIR__. '/bootstrap/start.php';

define("SERVER_IP", "0.0.0.0");
define("SERVER_PORT", 4444);

$loop   = Factory::create();
$webSock = new Server($loop);
$webSock->listen(SERVER_PORT, SERVER_IP); // Binding to 0.0.0.0 means remotes can connect
$webServer = new IoServer( new HttpServer( new WsServer(new Connection())), $webSock);
$loop->run();
