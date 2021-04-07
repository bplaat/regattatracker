<?php

namespace App\Signals;

use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;

abstract class Signal
{
    public function sendSignal($type, $data)
    {
        $loop = Factory::create();

        $connector = new Connector($loop, ['dns' => false]);
        $connector->connect(config('signals.host') . ':' . config('signals.port'))->then(function (ConnectionInterface $connection) use ($type, $data) {
            $data['type'] = $type;
            $connection->write(json_encode($data));
            $connection->end();
        });

        $loop->run();
    }
}
