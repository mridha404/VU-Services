<!-- resources/views/students-list.blade.php -->

@extends('layouts.app-master')

@section('content')
<div class="card border-2 my-4" style="margin: 20px; padding: 20px;">
    <div class="card-header">
        <h5 class="card-title">
            Students List
        </h5>

         <!-- Display success message if exists -->
         @if (session('success'))
         <div class="alert alert-success">
             {{ session('success') }}
         </div>
     @endif

        <h6 class="card-subtitle text-muted">
            List of students with names, roll numbers, mobile numbers, departments, and balances
        </h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered border-success">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Roll Number</th>
                    <th scope="col">Mobile Number</th>
                    <th scope="col">Department</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <th scope="row">{{ $student->id }}</th>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->rollnumber }}</td>
                        <td>{{ $student->mobile_number }}</td>
                        <td>{{ $student->department->department_name }}</td>
                        <td>৳{{ $student->balance }}</td>
                        <td>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('students.delete', $student) }}" method="post" class="d-inline">
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
</div>
@endsection
