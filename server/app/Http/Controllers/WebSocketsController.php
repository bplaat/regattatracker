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

    // Broadcast message to all open websocket connections
    public function broadcast(array $message): void
    {
        foreach ($this->connections as $connection) {
            $connection['connection']->send(json_encode($message));
        }
    }

    public function onSignal(string $type, object $data): void
    {
        // On new boat position signal
        if ($type == 'new_boat_position') {
            $boatPosition = BoatPosition::where('id', $data->boat_position_id)->first();

            $this->broadcast([
                'type' => 'new_boat_position',
                'boatPosition' => $boatPosition
            ]);
        }

        // On new buoy position signal
        if ($type == 'new_buoy_position') {
            $buoyPosition = BuoyPosition::where('id', $data->buoy_position_id)->first();

            $this->broadcast([
                'type' => 'new_buoy_position',
                'buoyPosition' => $buoyPosition
            ]);
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
