<!-- resources/views/students/create.blade.php -->

@extends('layouts.app-master')

@section('content')
    <div class="card border-2 my-4" style="margin: 35px; padding: 35px;">
        <div class="card-header">
            <h5 class="card-title text-white  p-1">
                Create Student
            </h5>
        </div>

        <!-- Display success message if exists -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display validation errors if they exist -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('students.store') }}" method="post" class="row g-3 bg-dark p-4 rounded">
            @csrf <!-- Add CSRF token -->

            <div class="col-12">
                <label for="inputName" class="form-label text-white">Name</label>
                <input type="text" name="name" class="form-control" id="inputName" placeholder="John Doe"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="inputEmail" class="form-label text-white">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="john.doe@example.com"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="inputRollNumber" class="form-label text-white">Roll Number</label>
                <input type="text" name="rollnumber" class="form-control" id="inputRollNumber"
                    placeholder="Enter Roll Number" value="{{ old('rollnumber') }}" required>
            </div>

            <div class="col-12">
                <label for="inputMobileNumber" class="form-label text-white">Mobile Number</label>
                <input type="text" name="mobile_number" class="form-control" id="inputMobileNumber"
                    placeholder="Enter Mobile Number" value="{{ old('mobile_number') }}" required>
            </div>


            <div class="mb-3">
                <label for="department_name" class="form-label">Department Name</label>
                <select class="form-select" id="department_name" name="department_name" required>
                    <option value="">Please select a Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="department_id" class="form-label">Department ID</label>
                <input type="text" class="form-control" id="department_id" name="department_id" readonly required>
                <small class="text-muted">The department ID will be updated based on your selection.</small>
            </div>

            <div class="col-12">
                <label for="inputUserId" class="form-label text-white">User ID</label>
                <input type="text" name="user_id" class="form-control" id="inputUserId" placeholder="123"
                    value="{{ auth()->user()->id }}" readonly>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Add Student</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('department_name').addEventListener('change', function() {
            // Update the hidden department_id input with the selected department ID
            document.getElementById('department_id').value = this.value;
        });
    </script>
@endsection
