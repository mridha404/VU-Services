<!-- resources/views/searchadd/addmoney.blade.php -->

@extends('layouts.app-master')

@section('content')

    <div class="card border-2 my-4" style="margin: 35px; padding: 35px;">
        <div class="card-header">
            <h5 class="card-title text-white  p-1">
                Add Money
            </h5>
        </div>

        <!-- Display success message if exists -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                @if (session('previousBalance') && session('updatedBalance'))
                    <br>
                    Previous Balance: ৳{{ session('previousBalance') }}<br>
                    Updated Balance: ৳{{ session('updatedBalance') }}
                @endif
            </div>
        @endif
        <!-- Search Form -->
        <div class="col-md-6 mb-3">
            <form action="{{ route('searchaddmoney.search') }}" method="GET" class="form-inline mb-3">
                @csrf <!-- Add CSRF token -->
                {{-- <div class="form-group  rounded p-2">
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
                </div> --}}
                <div class="form-group  rounded p-2">
                    <label for="searchInput" class="mr-2">Search Student Using Only Roll Number:</label>
                    <input type="text" name="search" id="searchInput" value="{{ $search }}"
                        placeholder="Search..." class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ url('/searchaddmoney') }}">
                    <button type="button" class="btn btn-primary ml-2">Reset</button>
                </a>
            </form>
        </div>
        <!-- Display Add Money Form for Selected Student -->
        @if ($search && count($students) > 0)
            <form action="{{ route('searchmoney.execute') }}" method="post" class="row g-3 bg-dark p-4 rounded">
                @csrf <!-- Add CSRF token -->

                <div class="col-12">
                    <label class="form-label text-white">Student Information</label>
                    @if (count($students) > 0)
                        <table class="table table-bordered border-success">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Roll Number</th>
                                    <th>Mobile Number</th>
                                    <th>Balance</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->rollnumber }}</td>
                                        <td>{{ $student->mobile_number }}</td>
                                        <td>৳{{ $student->balance }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->department->department_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-danger mt-3">
                            No students found for the given search criteria.
                        </div>
                    @endif
                </div>


                <div class="col-12">
                    <label for="date" class="form-label text-white">Date</label>
                    <input type="date" name="date" class="form-control" id="date" value="{{ date('Y-m-d') }}"
                        required readonly>
                </div>

                <div class="col-12">
                    <label for="amount" class="form-label text-white">Amount</label>
                    <input type="number" name="amount" class="form-control" id="amount" required>
                </div>
                <div class="col-12">
                    <label for="payment_method" class="form-label text-white">Payment Method</label>
                    <select name="payment_method" class="form-select">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="bank">Bank</option>
                    </select>
                </div>
                <div class="col-12" style="display: none;">
                    <label for="transaction_type" class="form-label text-white">Transaction Type</label>
                    <select name="transaction_type" class="form-select">
                        <option value="credit">Credit</option>
                        <option value="debit">Debit</option>
                    </select>
                </div>


                <!-- Add a hidden input field to pass $students data -->
                <input type="hidden" name="students" value="{{ json_encode($students) }}">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add Money</button>
                </div>
            </form>

            <!-- Include Transactions View -->
            @include('searchadd.showtransactions')
        @elseif ($search)
            <div class="alert alert-danger mt-3">
                No students found for the given search criteria.
            </div>
        @endif



    </div>

    <!-- Initialize Select2 for the department dropdown -->
    <script>
        $(document).ready(function() {
            $('#department').select2();
        });
    </script>
@endsection
