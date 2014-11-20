<?hh

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Connection implements MessageComponentInterface {
    protected $clients;

    public function __construct():void {
        $this->clients = new \SplObjectStorage;
	printf("Server Started Listening %s:%u\n", SERVER_IP, SERVER_PORT);
    }

    public function getClients():SplObjectStorage {
	return $this->clients;
    }

    public function onOpen(ConnectionInterface $conn):void {
	$conn->send(ViewType::Message("greeting"));	//Send Greeting
	$conn->action = ['Login', 'SelectUserName'];
	printf("User Connected!\n");
	$this->send($conn, "message", "Enter your character's name, or type new: ");
	$this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg):void {
	$msg = json_decode($msg);

	//Except Response
	foreach ($this->clients as $client) {
	   if ($client === $from) {
	      if (isset($client->action)) {
		 $client = self::Response ($client->action, $client, $msg);
		 return;
	      }

	      //General
	      switch ($msg->type) {
	         case 'message':
	            $message = new Message($client, $msg->data);
	          break;
	      }
	   }
	}
    }

    public static function Response ( $action, $client, $msg ) {
	$client = call_user_func_array($client->action, [$client, $msg]); //Call Static Class;
	unset($client->action);
	 return $client;
    }

    public function onClose(ConnectionInterface $conn):void {
	$this->clients->detach($conn);
	printf("User Disconnected!\n");
	$conn->close();
    }

    public function onError(ConnectionInterface $conn, \Exception $e):void {
	echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function cleanMsg(string $msg): string {
	return trim($msg);
    }

    public static function send (ConnectionInterface $conn, string $type, mixed $data):ConnectionInterface {
	return $conn->send(json_encode(['type' => $type, 'data' => $data]));
    }
}
