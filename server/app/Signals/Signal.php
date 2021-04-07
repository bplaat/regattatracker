<?php

namespace App\Signals;

use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;

abstract class Signal
{
    public function sendSignal(string $type, array $data): void
    {
        $loop = Factory::create();

        $connector = new Connector($loop, ['dns' => false]);
        $connector->connect(config('signals.host') . ':' . config('signals.port'))->then(function (ConnectionInterface $connection) use ($type, $data) {
            $connection->write(json_encode([
                'type' => $type,
                'data' => $data
            ]));
            $connection->end();
        });

        $loop->run();
    }
}
