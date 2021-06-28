[&laquo; Back to the README.md](../README.md)

# Websockets Documentatie
De website maakt gebruik van een websockets server dit zorgt ervoor dat je live positie updates kan ontvangen op een effiecente manier.

Je kan de websockets server onstarten door in de `server` folder het volgende commando te runnen:
```
php artisan websockets:serve
```
Dit start de websockets server op en de signals IPC server. De websockets server staat open naar de buitenwereld zo kunnen website clients ermee verbinden. De signals IPC server mag niet open zijn voor de buitenwereld. Deze simpele TPC server is er alleen maar voor op berichtjes tussen de verschillende PHP processes te sturen.

## Waarom is dit alles geschreven in PHP?
Ik weet dat het schrijven van een websockets server in PHP eigenlijk een beetje vreemd is aangezien PHP 100% state less is en gewoon draaid bij elk HTTP request is het niet echt geschikt voor langdraaiende programma's zoals servers. Dit wil alleen niet zeggen dat het onmogelijk is. Met de `Rachet` lib die gebruik maakt van `ReactPHP` is asychrone client server stuff vrij elegant te maken.

Het voordeel was dat de rest van de backend ook al in PHP was geschreven. En als we het in een andere taal (bijvoorbeeld JavaScript met Nodejs of Deno) zouden maken zou dat raar zijn geweest. Ook kunnen we zo in onze websockets server gewoon gebruik maken van de Laravel (Eloqent) APIs zo kunnen we overal de zelfde database code / models gebruiken. Al met al was dit een goede keuze geweest die veel werk uithanden heeft genomen.

## IPC communcatie / Signals Systeem
Het grooste probleem is eigenlijk dat er niet een vaste PHP process is maar een Apache (webserver) process met meerdere PHP verwerkers (noem ik het maar even) en een los PHP websockets process. We krijgen natuurlijk de nieuwe informatie binnen via een onze website of REST API die leven in die Apache process boom. Deze moeten stel als ze een nieuwe positie invoegen een bericht sturen naar de websockets server. Om dit te doen hebben we het signals systeem gemaakt.

Om een signal aan te maken maak je in de `app/Signals` folder een nieuwe class aan die `Signal` extend, dan roep je de functie `sendSignal` aan met de naam en dat data die je wilt verzenden:
```php
class NewBoatPositionSignal extends Signal
{
    public function __construct(BoatPosition $boatPosition)
    {
        $this->sendSignal('new_boat_position', [
            'boat_position_id' => $boatPosition->id
        ]);
    }
}
```
Om de singal aan te roepen maak je gewoon een nieuwe instance van deze class aan:
```php
new NewBoatPositionSignal($boatPosition);
```
De singals komen dan in de `WebsocketsController.php` weer binnen en deze broadcast dan een bericht naar alle luisterende clients die dan een bericht weer binnen krijgen:
```php
public function onSignal(string $type, object $data): void
{
    if ($type == 'new_boat_position') {
        $boatPosition = BoatPosition::where('id', $data->boat_position_id)->first();

        $this->broadcast([
            'type' => 'new_boat_position',
            'boatPosition' => $boatPosition
        ]);
    }
}
```
Zo werkt het signals systeem het is dus eigenlijk een simpele methode op het beetje data naar de websockets server te sturen in een andere process.

## Werking van het Signals Systeem
De werking van het signals systeem is vrij simpel het verstuurd namelijk gewoon een TCP bericht naar de lokale signals server (die wel in hetzelfde process draaid als de websockets server) met daarin een json string met de message type en de data:
```php
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
```
In het websocket server command staat de code voor de TCP signals server en wanneer er een bericht binnen komt roept deze de `onSignal` functie aan van de websockets controller:
```php
$socketServer = new Server('127.0.0.1:' . config('signals.port'), $loop);
$socketServer->on('connection', function (ConnectionInterface $connection) use ($websocketsController) {
    $connection->on('data', function ($data) use ($websocketsController) {
        $data = json_decode($data);
        echo '[INFO] Signal: ' . $data->type . ' ' . json_encode($data->data)PHP_EOL;
        $websocketsController->onSignal($data->type, $data->data);
    });

    $connection->on('error', function (\Exception $exception) {
        echo '[ERROR] Signal error: ' . $exception->getMessage() . PHP_EOL;
    });
});
```
Dat is eigenlijk het gehele singals systeem de websockets die daar boven op draaien zijn gewoon JSON berichtjes die worden verwerkt in de `live_map.js`.
