<?hh

use Ratchet\ConnectionInterface;

class Message {

	protected $type = "message";
	protected $messageData;
	protected $client;

	public function __construct (ConnectionInterface $client, string $data):void {
	   $this->messageData = $data;
	   $this->client = $client;

	   $this->Parse();
	}

	protected function Parse():void {
	   $message = explode(" ", $this->messageData, 2);

	   switch (strtolower(trim($message[0]))) {
	      case '/chat':
		  $this->Chat($message[1]);
		break;
	      default: 
		  Connection::send($this->client, $this->type, "I do not understand");
		break;
	   }
	}

	public function Chat (string $msg): void
	{
	   global $conn;
	   $clients = $conn->getClients();

	   foreach ($clients as $client) {
		Connection::send($client, $this->type, $this->client->name . ": " . $msg);
	   }
	}
}
