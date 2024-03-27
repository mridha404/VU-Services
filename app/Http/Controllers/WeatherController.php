<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
    public function getWeather()
    {
        // Replace 'YOUR_API_KEY' with your OpenWeather API key
        $apiKey = 'cd257036ebf74c03ef785d3427877931';

        // Define latitude and longitude coordinates
        $latitude = '24.3746'; // Replace with actual latitude
        $longitude = '88.6004'; // Replace with actual longitude

        // Create a new Guzzle client instance
        $client = new Client();

        // API endpoint URL with latitude, longitude, and API key
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$latitude}&lon={$longitude}&appid={$apiKey}";

        try {
            // Make a GET request to the OpenWeather API
            $response = $client->get($apiUrl);

            // Check if the response is successful
            if ($response->getStatusCode() === 200) {
                // Get the response body as an array
                $data = json_decode($response->getBody(), true);

                // Handle the retrieved weather data as needed (e.g., pass it to a view)
                return view('weather.weather', ['weatherData' => $data]);
            } else {
                // Handle non-successful response
                return view('weather.api_error', ['error' => 'Failed to fetch weather data.']);
            }
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return view('weather.api_error', ['error' => $e->getMessage()]);
        }
    }
}
