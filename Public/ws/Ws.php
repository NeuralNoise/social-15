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
        $now = now();
        echo "New connection! ({$conn->resourceId}) ({$now})\n";
    }

    public function onMessage(ConnectionInterface $conn, $req) {
        $req = json_decode($req);
        if (is_object($req) ) {
            if ($req->type === 'set_user' && empty($conn->user) ) {
                $conn->user = $req->username;

            } else if ($req->type === 'send_message') {
                $msg = sanitize($req->msg);
                $this->add_to_DB($conn->user, $req->to, $msg);
                $this->send($req, $msg, $conn);

            } else if ($req->type === 'msg_check') {
                $this->msg_check($conn->user);
            } else if ($req->type === 'writing' ) {
                $this->writing($req->to, $conn);
            }
        } else {
            echo $req . "\n";
        }
        
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->connections->detach($conn);
        $now = now();
        echo "Connection {$conn->user} has disconnected ({$now})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    private function msg_check($user) {
        $u = User::find($user);
        $u->msg_check = now();
        $u->save();
        echo "Connection {$user} checking messages. \n";
    }

    private function writing($to, $conn) {
        foreach ($this->connections as $client) {
            if ($conn !== $client && strcmp($client->user, $to) === 0) {
                $res = array('writing' => 1);
                $client->send(json_encode($res) );
            }
        }
        echo 'yeah';
    }

    private function send($req, $msg, $conn) {
        foreach ($this->connections as $client) {
            if ($conn !== $client && strcmp($client->user, $req->to) === 0) {
                $msg_check = User::find($client->user)->msg_check;
                $options = array('conditions' => array('to_user = ? AND date > ?', $client->user, $msg_check),
                         'group' => 'from_user' );
                $nMsg = count(Chat::all($options) );
                $res = array('msg' => $msg, 'nMsg' => $nMsg);
                $client->send(json_encode($res) );

                echo "Connection {$conn->user} sending message '{$req->msg}' to {$req->to}. \n";
            }
        }
    }

    private function add_to_DB($from, $to, $msg) {
        Chat::create(array(
            'from_user' => $from,
            'to_user' => $to,
            'msg' => $msg,
            'date' => now()
            ));
    }
}