<!-- resources/views/students/edit.blade.php -->

@extends('layouts.app-master')

@section('content')
<div class="card border-2 my-4" style="margin: 20px; padding: 20px;">
        <h1>Edit Student</h1>

        <!-- Display validation errors if any -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display success message if it exists -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Edit student form -->
        <form action="{{ route('students.update', $student) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $student->email }}" required>
            </div>
            <div class="mb-3">
                <label for="rollnumber" class="form-label">Roll Number</label>
                <input type="text" class="form-control" id="rollnumber" name="rollnumber" value="{{ $student->rollnumber }}" required>
            </div>
            <div class="mb-3">
                <label for="mobile_number" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ $student->mobile_number }}" required>
            </div>
         
            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    </div>
@endsection
