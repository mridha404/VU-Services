@extends('layouts.app-master')

@section('content')
    <div class="card border-2 my-4" style="margin: 25px; padding: 25px;">
        <div class="card-header">
            <h5 class="card-title text-white  p-1">
                Search Here Using Department Name Roll Number and Mobile Number
            </h5>

            <!-- Display success message if exists -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h6 class="card-title text-white  p-1">
                List of Students
            </h6>
        </div>
        <div class="card-body">

            {{-- search using name eamil roll number  important code --}}

            {{-- <form action="{{ route('search-student') }}" method="GET" class="form-inline">
                <div class="col-md-6 mb-3">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search..." class="form-control mr-2">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{url('/search-student')}}">
                    <button type="button" class="btn btn-primary" >Reset</button>
                </a>
                
            </form> --}}

            <!-- HTML form with two search fields (name and department) -->
            <div class="mb-3">
                <form action="{{ route('search-student') }}" method="GET" class="form-inline d-flex justify-content-between align-items-center">
                    <div class="form-group rounded p-2 mr-3">
                        <label for="department" class="mr-2">Department:</label>
                        <select id="department" name="department" class="form-control">
                            <option value="">All Departments</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $selectedDepartment == $department->id ? 'selected' : '' }}>
                                    {{ $department->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group rounded p-2 mr-3">
                        <label for="nameInput" class="mr-2">Name:</label>
                        <input type="text" name="name" id="nameInput" value="{{ $name }}"
                            placeholder="Enter name..." class="form-control mr-2">
                    </div>
                    <div class="form-group rounded p-2 mr-3">
                        <label for="rollNumberInput" class="mr-2">Roll Number:</label>
                        <input type="text" name="rollnumber" id="rollNumberInput" value="{{ $rollnumber }}"
                            placeholder="Enter roll number..." class="form-control mr-2">
                    </div>
                    <div class="form-group rounded p-2 mr-3">
                        <label for="mobileNumberInput" class="mr-2">Mobile Number:</label>
                        <input type="text" name="mobile_number" id="mobileNumberInput" value="{{ $mobile_number }}"
                            placeholder="Enter mobile number..." class="form-control mr-2">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary mt-3">Search</button>
                        <a href="{{ url('/search-student') }}" class="ml-3">
                            <button type="button" class="btn btn-primary mt-3">Reset</button>
                        </a>
                    </div>
                </form>
            </div>
            
            
            




            @if (count($students) > 0)
                <table class="table table-bordered border-success">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
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
                                    <a href="{{ route('students.edit', $student) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('students.delete', $student) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center">
                    @if ($students->total() > $students->perPage())
                        {{ $students->links() }}
                    @endif
                </div>
            @else
                <div class="alert alert-danger">
                    @if ($selectedDepartment !== null)
                        No students found for the given search criteria in the selected department.
                    @else
                        No students found for the given search criteria.
                    @endif
                </div>
            @endif

        </div>
    </div>

    <!-- Initialize Select2 for the department dropdown -->
    <script>
        $(document).ready(function() {
            $('#department').select2();
        });
    </script>

@endsection
