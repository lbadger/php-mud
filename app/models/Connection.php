<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Connection implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
	printf("Server Started Listening %s:%u\n", SERVER_IP, SERVER_PORT);
    }

    public function onOpen(ConnectionInterface $conn) {
	$this->clients->attach($conn);
	$conn->send(ViewType::Message('greeting'));	//Send Greeting
	$conn->send(ViewType::Message('greeting'));	//Send Greeting
	$conn->send(ViewType::Message('greeting'));	//Send Greeting
	$conn->send(ViewType::Message('greeting'));	//Send Greeting
	$conn->send(ViewType::Message('greeting'));	//Send Greeting
	$conn->send(ViewType::Message('greeting'));	//Send Greeting
	printf("User Connected!\n");
    }

    public function onMessage(ConnectionInterface $from, $msg) {
	foreach ($this->clients as $client) {
	     $client->send($this->cleanMsg($msg));
	}
    }

    public function onClose(ConnectionInterface $conn) {
	$this->clients->detach($conn);
	printf("User Disconnected!\n");
	$conn->close();
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
	echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function cleanMsg($msg) {
	return trim($msg);
    }
}
