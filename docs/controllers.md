[&laquo; Back to the README.md](../README.md)

# Controllers Documentatie
In een Laravel project heb je natuurlijk controllers nodig. Op deze pagina zal ik door een aantal controllers heen lopen om uitteleggen wat ze doen en hoe ze werken. Dit om je een indruk te geven van hoe de gehele controller code base verder werkt.

## Booten Controller voorbeeld

### Index route
In de index method van deze controller kijken we eerst of er een zoek query word meegegeven in de q GET variabele. Als die er is dan selecteren we eerste alle boat modelen van de authed user die filteren we dan door te zoeken via de zoek query als de zoek query niet word gegeven filteren we er geen boten uit:
```php
public function index()
{
    // When a query is given search by query
    $query = request('q');
    if ($query != null) {
        $boats = Boat::searchCollection(Auth::user()->boats, $query);
    } else {
        $boats = Auth::user()->boats;
    }
```
Wat sorteren dan de boaten op naam case insensitve en voegen we paginatie toe:
```php
    $boats = $boats->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
        ->sortByDesc('pivot.role')->paginate(config('pagination.web.limit')->withQueryString();
```
Als laatste returnen we de `boats.index` view met de goede boat data:
```php
    // Return boat index view
    return view('boats.index', ['boats' => $boats]);
}
```

### Store route
Als we een nieuwe boot willen aanmaken valideren we eerst de input op verschillende kenmerken per veld:
```php
public function store(Request $request)
{
    // Validate input
    $fields = $request->validate([
        'name' => 'required|min:2|max:48',
        'description' => 'nullable|max:20000',
        // ...
        'sail_number' => ['required', new SailNumber],
        'sail_area' => 'required|numeric|min:1|max:10000'
    ]);
```
Vervolgens maken we de nieuwe boat model aan dit zorgt er voor dat er ook automatisch een nieuwe row in onze database tabel komt:
```php
    // Create boat
    $boat = Boat::create([
        'name' => $fields['name'],
        'description' => $fields['description'],
        // ...
        'sail_number' => $fields['sail_number'],
        'sail_area' => $fields['sail_area']
    ]);
```
Daarna kijken we of er een plaatje is mee upgeload als dit is gebeurd valideren we het plaatje en schrijven we het weg naar de `store` folder:
```php
        // Update boat image when not empty
        if (request('image') != '') {
            $fields = $request->validate([
                'image' => 'required|image'
            ]);

            // Save file to boats folder
            $image = Boat::generateImageName($request->file('image')->extension());
            $request->file('image')->storeAs('public/boats', $image);

            // Delete old boat image
            if ($boat->image != null) {
                Storage::delete('public/boats/' . $boat->image);
            }

            // Update boat that he has an image
            $boat->update([ 'image' => $image ]);
        }
```
Als laatste verbinden we de ingelogde gebuiker als eigenaar aan de boot en redirecten we naar de verse `boats.show` route:
```php
        // Add authed user to boat as owner
        $boat->users()->attach(Auth::user(), [
            'role' => BoatUser::ROLE_OWNER
        ]);

        // Go to the new boat page
        return redirect()->route('boats.show', $boat);
    }
```

## Admin Api Keys Controller voorbeeld

### Update route
Als eerste valideren we de input als je een API key wilt aanpassen:
```php
public function update(Request $request, ApiKey $apiKey)
{
    // Validate input
    $fields = $request->validate([
        'name' => 'required|min:2|max:48',
        'level' => 'required|integer|digits_between:' .ApiKey::LEVEL_REQUIRE_AUTH . ',' . ApiKey::LEVEL_NO_AUTH
    ]);
```
Daarna updaten we de api key model die we al bestond en die wel al binnen hadden door route model binding:
```php
    // Update API key
    $apiKey->update([
        'name' => $fields['name'],
        'level' => $fields['level']
    ]);
```
Als laatste redirecten we terug naar de `admin.api_keys.show` route:
```php
    // Go to the admin API key page
    return redirect()->route('admin.api_keys.show', $apiKey);
}
```

### Delete route
Deze route is vrij simple, eerst verwijderen we de api key die we via route model binding hebben binnen gekregen, daarna redirecten we terug naar de `admin.api_keys.index` route:
```php
public function delete(ApiKey $apiKey)
{
    // Delete API key
    $apiKey->delete();

    // Go to the API keys index page
    return redirect()->route('admin.api_keys.index');
}
```

## Api Booten Posities Controller voorbeeld

### Store route
Als we een nieuwe boot positie willen toevoegen roepen we deze method aan. Het eerste wat we doen is checken of de latitude en longitude die we hebben binnen gekregen ook echte floating point numbers zijn:
```php
public function store(Request $request, Boat $boat)
{
    // Validate input
    $validation = Validator::make($request->all(), [
        'latitude' => ['required', new Latitude],
        'longitude' => ['required', new Longitude]
    ]);
```
Stel er is een validatie error returnen we een json response met http status code 400 en een array met de fouten die zijn gevonden:
```php
    if ($validation->fails()) {
        return response(['errors' => $validation->errors()], 400);
    }
```
Als alles klopt maken we een nieuwe positie aan voor de boat:
```php
    // Create boat position
    $boatPosition = $boat->positions()->create([
        'latitude' => request('latitude'),
        'longitude' => request('longitude')
    ]);
```
Daarna maken we een nieuwe signal aan voor de websocket server om alle websocket verbindingen te laten weten dat er voor deze boot een nieuwe positie is binnen gekomen:
```php
    // Send new boat position signal to websockets server
    new NewBoatPositionSignal($boatPosition);
```
Als laatste returnen we de net aangemaakt boat positie model in json
```php
    // Return the new created boat position
    return $boatPosition;
}
```
