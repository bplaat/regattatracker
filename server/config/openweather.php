<?php

return [
    'api_key' => env('OPENWEATHER_API_KEY'),
    'api_endpoint_current' => 'api.openweathermap.org/data/2.5/weather?q=Enkhuizen&appid={API key}',
    'api_endpoint_forecast' => 'api.openweathermap.org/data/2.5/forecast?id=524901&appid={API key}',
    'api_endpoint_geo' => 'api.openweathermap.org/data/2.5/weather?lat={lat}&lon={lon}&appid={API key}'
];