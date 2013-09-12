<?php

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;


    require dirname(__DIR__) . '/vendor/autoload.php';
	require 'Ws.php';

    $server = IoServer::factory(
        new WsServer(new Ws() ), 8080 );

    $server->run();