#!/usr/bin/hhvm
<?php
use Ratchet\Server\IoServer;

require __DIR__.'/bootstrap/paths.php';
require __DIR__. '/bootstrap/autoload.php';
require __DIR__. '/bootstrap/start.php';

$server = IoServer::factory(new Connection(), 8080);
$server->run();
