<!-- resources/views/search-department/index.blade.php -->

@extends('layouts.app-master')

@section('content')
    <div class="container">
        <div class="card border-2 my-4" style="margin: 20px; padding: 20px;">
            <div class="card-header">
                <h1 class="card-title mb-1 py-2">Search Department</h1>
            </div>

            <div class="card-body">
                <form action="{{ route('search-department.search') }}" method="get">
                    @csrf

                    <div class="col-md-6 mb-3">
                        <label for="department">Select Department:</label>
                        <select class="form-control" name="department_id" id="department">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                @if(count($students) > 0)
                <h2 class="mt-4">Search Results</h2>
                <table class="table table-bordered border-success">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Roll Number</th>
                            <th scope="col">Mobile Number</th>
                            <th scope="col">Department</th>
                            <th scope="col">Balance</th>
                            
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
                              
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger mt-4">
                    <strong>No students found.</strong> Please try again with a different department.
                </div>
            @endif
            </div>
        </div>
    </div>

    <!-- Include Select2 JS and Initialize -->

    <script>
        $(document).ready(function() {
            $('#department').select2({
                placeholder: 'Select Department',
                allowClear: true
            });
        });
    </script>
@endsection
