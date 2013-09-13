<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Ws implements MessageComponentInterface {
    protected $connections;

    public function __construct() {
        $this->connections = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->connections->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $conn, $msg) {
        if (strcmp(substr($msg, 0, 19), 'mvql284nf/username:') === 0) {
            if (empty($conn->user) ) {
                $conn->user = trim(substr($msg, 19) );
            }

        } else if (strcmp(substr($msg, 0, 13), 'mvql284nf/to:') === 0) {
            list($to, $msg) = $this->desanitize_msg($msg);

            foreach ($this->connections as $client) {
                if ($conn !== $client && strcmp($client->user, $to) === 0) {
                    // The sender is not the receiver, send to each client connected
                    echo "Connection {$conn->user} sending message {$msg} to {$to}. \n";
                    $client->send($msg);
                }
            }
        }
        
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->connections->detach($conn);

        echo "Connection {$conn->user} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    private function desanitize_msg($msg) {
        $msg = trim(substr($msg, 13) );
        $colon = strpos($msg, ':');
        return array(substr($msg, 0, $colon), htmlspecialchars(substr($msg, $colon + 1)));

    }
}