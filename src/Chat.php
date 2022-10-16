<?php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require dirname(__DIR__) . "/database/ChatUser.php";
require dirname(__DIR__) . "/database/ChatRooms.php";

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo 'Server Started'. PHP_EOL .'Web URL: http://chat.test'; 

    }

    public function onOpen(ConnectionInterface $conn) {
        session_start();
        // Store the new connection to send messages to later
        echo 'Server Started';
        $this->clients->attach($conn);
        echo "New xx connection! ({$conn->resourceId})\n";

        $_SERVER['resourceId'] = $conn->resourceId;
        $_SESSION['resourceId'] = $conn->resourceId;
        echo "lol" .  $_SESSION['resourceId'];
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $data['userId'] =  $from->resourceId;
        $data['msg'] = $msg; 
        // $data = json_decode($msg, true);



        $chat_object = new \ChatRooms;

        $chat_object->setUserId($data['userId']);

        $chat_object->setMessage($data['msg']);

        $chat_object->setCreatedOn(date("Y-m-d h:i:s"));

        $chat_object->save_chat();

        $user_object = new \ChatUser;

        $user_object->setUserId($data['userId']);

        $user_data = $user_object->get_user_data_by_id();
        $user_data['user_name']="test";
        $user_name = $user_data['user_name'];

        $data['dt'] = date("d-m-Y h:i:s");


        foreach ($this->clients as $client) {
            /*if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }*/

            if($from == $client)
            {
                $data['from'] = 'Me';
            }
            else
            {
                $data['from'] = $user_name;
            }

            $client->send(json_encode($data));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

?>
 
