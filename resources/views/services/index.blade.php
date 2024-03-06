<!-- resources/views/services/index.blade.php -->

@extends('layouts.app-master')

@section('content')
    <div class="card border-2 my-4" style="margin: 35px; padding: 35px;">

        <div class="card-header">
            <h1>Service List</h1>
        </div>


        

        <!-- Display success message if exists -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->servicename }}</td>
                        <td>{{ $service->servicedescription }}</td>
                        <td>৳{{ number_format($service->price, 2) }}</td>
                        <td>
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('services.delete', $service) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
