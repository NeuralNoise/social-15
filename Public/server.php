<?php

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require_once 'includes/social.php';
require '/ws/vendor/autoload.php';
require 'ws/Ws.php';

$server = IoServer::factory(
    new WsServer(new Ws() ), 8080 );

$server->run();