<?php

namespace App\Http\Controllers;

use App\Models\BoatPosition;
use App\Models\BuoyPosition;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketsController extends Controller implements MessageComponentInterface
{
    private $connections = [];

    public function onOpen(ConnectionInterface $connection)
    {
        $this->connections[$connection->resourceId] = ['connection' => $connection];
    }

    public function newBoatPosition($boatPositionId)
    {
        // Get new boat position
        $boatPosition = BoatPosition::where('id', $boatPositionId)->first();

        // Broadcast new boat position message
        foreach ($this->connections as $connection) {
            $connection['connection']->send(json_encode([
                'type' => 'new_boat_position',
                'boatPosition' => $boatPosition
            ]));
        }
    }

    public function newBuoyPosition($buoyPositionId)
    {
        // Get new buoy position
        $buoyPosition = BuoyPosition::where('id', $buoyPositionId)->first();

        // Broadcast new buoy position message
        foreach ($this->connections as $connection) {
            $connection['connection']->send(json_encode([
                'type' => 'new_buoy_position',
                'buoyPosition' => $buoyPosition
            ]));
        }
    }

    public function onMessage(ConnectionInterface $connection, $message)
    {
        // Just print the incomming message for know
        echo '[INFO] WebSocket message: ' . $message . PHP_EOL;
    }

    public function onClose(ConnectionInterface $connection)
    {
        unset($this->connections[$connection->resourceId]);
    }

    public function onError(ConnectionInterface $connection, \Exception $exception)
    {
        echo '[ERROR] WebSocket error: ' . $exception->getMessage() . PHP_EOL;

        unset($this->connections[$connection->resourceId]);
        $connection->close();
    }
}
