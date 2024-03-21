@extends('layouts.app-master')

@section('content')
    @if (isset($weatherData))
        <h1>Current Weather</h1>
        <table class="table table-bordered border-success">
            <thead>
                <tr>
                    <th>Attribute</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Location</td>
                    <td>{{ $weatherData['name'] }}</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>{{ $weatherData['weather'][0]['description'] }}</td>
                </tr>
                <tr>
                    <td>Temperature</td>
                    <td>{{ round($weatherData['main']['temp'] - 273.15, 2) }} &#8451;</td>
                </tr>
                <tr>
                    <td>Feels Like</td>
                    <td>{{ round($weatherData['main']['feels_like'] - 273.15, 2) }} &#8451;</td>
                </tr>
                <tr>
                    <td>Humidity</td>
                    <td>{{ $weatherData['main']['humidity'] }}%</td>
                </tr>
                <tr>
                    <td>Wind Speed</td>
                    <td>{{ $weatherData['wind']['speed'] }} m/s</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>No weather data available.</p>
    @endif
@endsection
