@extends('layouts.app-master')

@section('content')
    <div class="card-body">
        <h1>An error occurred while fetching weather data:</h1>
        <p>{{ $error }}</p>
    </div>
@endsection
