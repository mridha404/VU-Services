<!-- resources/views/courses/create.blade.php -->

@extends('layouts.app-master')

@section('content')
    <div class="card border-2 my-4" style="margin: 35px; padding: 35px;">
        <h1 class="mb-4">Add Course</h1>

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

        <!-- Add course form here -->
        <form action="{{ route('courses.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="instructor" class="form-label">Instructor</label>
                <input type="text" class="form-control" id="instructor" name="instructor" required>
            </div>
            <div class="mb-3">
                <label for="schedule" class="form-label">Schedule</label>
                <input type="text" class="form-control" id="schedule" name="schedule" required>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" required>
            </div>
            <div class="mb-3">
                <label for="fee" class="form-label">Fee</label>
                <input type="number" class="form-control" id="fee" name="fee" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="prerequisites" class="form-label">Prerequisites</label>
                <textarea class="form-control" id="prerequisites" name="prerequisites" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Add Course</button>
        </form>
    </div>
@endsection
