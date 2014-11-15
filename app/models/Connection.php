<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Connection implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
	$this->clients->attach($conn);
	$conn->send(View::make('greeting'));	//Send Greeting
    }

    public function onMessage(ConnectionInterface $from, $msg) {
    }

    public function onClose(ConnectionInterface $conn) {
	$this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}
