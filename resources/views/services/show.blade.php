<!-- resources/views/services/show.blade.php -->
@extends('layouts.app-master')

@section('content')
    <h1>{{ $service->servicename }}</h1>
    <p>{{ $service->servicedescription }}</p>
    <p>Price: {{ $service->price }}</p>
@endsection
