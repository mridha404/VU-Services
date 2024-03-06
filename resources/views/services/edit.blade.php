<!-- resources/views/services/edit.blade.php -->

@extends('layouts.app-master')

@section('content')
    <div class="card border-2 my-4" style="margin: 40px; padding: 40px;">
        <h1>Edit Service</h1>

             <!-- Display success message if exists -->

             @if ($errors->any())
             <div class="alert alert-danger">
                 <ul>
                     @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                     @endforeach
                 </ul>
             </div>
         @endif

        <!-- Edit service form here -->
        <form action="{{ route('services.update', $service) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="servicename" class="form-label">Service Name</label>
                <input type="text" class="form-control" id="servicename" name="servicename" value="{{ $service->servicename }}" required>
            </div>
            <div class="mb-3">
                <label for="servicedescription" class="form-label">Description</label>
                <textarea class="form-control" id="servicedescription" name="servicedescription" required>{{ $service->servicedescription }}</textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $service->price }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Service</button>
        </form>
    </div>
@endsection
