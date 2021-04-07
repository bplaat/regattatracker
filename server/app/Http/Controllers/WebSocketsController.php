<?php

namespace App\Http\Controllers;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketsController extends Controller implements MessageComponentInterface
{
    private $connections = [];

    public function onOpen(ConnectionInterface $connection)
    {
        $this->connections[$connection->resourceId] = ['connection' => $connection];
    }

    public function onMessage(ConnectionInterface $connection, $message)
    {
        echo '[INFO] Message: ' . $message . "\n";
    }

    public function onClose(ConnectionInterface $connection)
    {
        unset($this->connections[$connection->resourceId]);
    }

    public function onError(ConnectionInterface $connection, \Exception $error)
    {
        echo '[ERROR] ' . $error->getMessage() . "\n";

        unset($this->connections[$connection->resourceId]);
        $connection->close();
    }
}
