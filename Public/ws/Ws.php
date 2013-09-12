<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Ws implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $conn, $msg) {
        if (strcmp(substr($msg, 0, 18), '192837465username:') === 0) {
            if (empty($conn->user) ) {
                $conn->user = substr($msg, 18);
            }
        } else {
            $numRecv = count($this->clients) - 1;
            echo sprintf('Connection %s sending message "%s" to %d other connection%s' . "\n"
                , $conn->user, $msg, $numRecv, $numRecv == 1 ? '' : 's');

            foreach ($this->clients as $client) {
                if ($conn !== $client) {
                    // The sender is not the receiver, send to each client connected
                    $client->send($msg);
                }
            }
        }
        
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->user} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}