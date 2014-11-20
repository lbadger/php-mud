<?hh

use Ratchet\ConnectionInterface;

class Login {

	public static function SelectUserName (ConnectionInterface $client, StdClass $msg): ConnectionInterface {
	   Connection::send($client, 'message', $msg->data);
	   $client->name = $msg->data;
	   return $client;
	}	

}
