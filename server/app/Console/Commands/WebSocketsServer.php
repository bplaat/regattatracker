<?php

namespace App\Console\Commands;

use App\Http\Controllers\WebSocketsController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Server;

class WebSocketsServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websockets:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the websockets server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $loop = Factory::create();

        $websocketsController = new WebSocketsController();

        // Start signals server
        echo '[INFO] Starting signals server at: ' . config('signals.host') . ':' . config('signals.port') . PHP_EOL;
        $socketServer = new Server(config('signals.host') . ':' . config('signals.port'), $loop);
        $socketServer->on('connection', function (ConnectionInterface $connection) use ($websocketsController) {
            $connection->on('data', function ($data) use ($websocketsController) {
                $data = json_decode($data);

                echo '[INFO] Signal: ' . $data->type . ' ' . json_encode($data->data). PHP_EOL;

                $websocketsController->onSignal($data->type, $data->data);
            });

            $connection->on('error', function (\Exception $exception) {
                echo '[ERROR] Signal error: ' . $exception->getMessage() . PHP_EOL;
            });
        });

        // Start websockets server
        echo '[INFO] Starting websockets server at: ws://' . config('websockets.host') . ':' . config('websockets.port') . '/' . PHP_EOL;
        $websocketServer = new IoServer(
            new HttpServer(new WsServer($websocketsController)),
            new Server(config('websockets.host') . ':' . config('websockets.port'), $loop),
            $loop
        );

        $loop->run();
    }
}
