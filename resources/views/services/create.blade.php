<!-- resources/views/services/create.blade.php -->

@extends('layouts.app-master')

@section('content')
    <div class="card border-2 my-4 " style="margin: 35px; padding: 35px ;">
        <h1 class="mb-4">Add Service</h1>

        <!-- Display success message if exists -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add service form here -->
        <form action="{{ route('services.store') }}" method="post" > 
            @csrf
            <div class="mb-3">
                <label for="servicename" class="form-label">Service Name</label>
                <input type="text" class="form-control" id="servicename" name="servicename" required>
            </div>
            <div class="mb-3">
                <label for="servicedescription" class="form-label">Description</label>
                <textarea class="form-control" id="servicedescription" name="servicedescription" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Add Service</button>
        </form>
    </div>
@endsection
