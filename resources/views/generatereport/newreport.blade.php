@extends('layouts.app-master')

@section('content')
    <h1 class="p-2 rounded m-4" style="font-size: 1.5rem;">Students Services Report Generation Builder</h1>

    <!-- Search fields for department and roll number -->
    <div class="p-2 border border-gray-200 rounded" style="margin: 20px;">
        <form method="GET" action="{{ route('generatereport') }}">
            @csrf
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="department" class="col-sm-4 col-form-label">Department:</label>
                        <div class="col-sm-8">
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
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="rollNumber" class="col-sm-4 col-form-label">Roll Number:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="rollNumber" name="rollNumber"
                                placeholder="Enter roll number...">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row align-items-end">
                        <div class="col-sm-12 ">
                            <button type="submit" class="btn btn-outline-success ">Search</button>
                            <input type="submit" name="export" value="Export to Excel"
                                class="btn btn-outline-primary mx-1">

                            <a href="{{ url('/reports/generate-report') }}" class="mt-3">
                                <button type="button" class="btn btn-outline-success">Reset</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="col-sm-12">

                <input type="submit" name="csv" value="Export to Csv" class="btn btn-outline-primary mx-1">
                <input type="submit" name="pdf" value="Export to Pdf" class="btn btn-outline-primary mx-1">
            </div>
        </form>

        <!-- Row for export buttons -->
        {{-- <form id="exportForm" method="POST" action="{{ route('export-report') }}">
            @csrf
            <input type="hidden" name="export_format" id="exportFormatInput">

            <button type="button" class="btn btn-outline-primary mx-1" onclick="exportToExcel()">Export to Excel</button>
            <button type="button" class="btn btn-outline-primary mx-1" onclick="exportToCSV()">Export to CSV</button>
            <button type="button" class="btn btn-outline-primary mx-1" onclick="exportToPDF()">Export to PDF</button>

        </form> --}}

        {{-- <button type="button" class="btn btn-outline-primary mx-1" onclick="exportToExcel(this, 'all')">Export to
            Excel</button>
        <button type="button" class="btn btn-outline-primary mx-1" onclick="exportToExcel(this, 'selected')">Export
            Selected to Excel</button> --}}
        {{-- <input type="submit" name="csv" value="Export to Csv" class="btn btn-outline-primary mx-1">
        <input type="submit" name="pdf" value="Export to Pdf" class="btn btn-outline-primary mx-1"> --}}

        {{-- <form id="exportForm" method="POST" action="{{ route('export-selected-students') }}" style="display: none;">
            @csrf


            <input type="hidden" name="export_format" id="exportFormatInput">
        </form> --}}



    </div>


    <div class="table-container mt-4 mb-4 ml-2 mr-2">
        <table class="table table-bordered border-success">
            <thead>
                <tr>
                    {{-- <th class="text-success selectCheckbox">Select</th> --}}
                    <th class="text-success studentName">Student Name</th>
                    <th class="text-success rollNumber">Roll Number</th>
                    <th class="text-success mobileNumber">Mobile Number</th>
                    <th class="text-success balance">Balance</th>
                    <th class="text-success departmentName">Department Name</th>
                    <th class="text-success transactionDate">Transaction Date</th>
                    <th class="text-success transactionAmount">Transaction Amount</th>
                    <th class="text-success serviceName">Service Name</th>

                    <th class="text-success serviceQuantity">Service Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        {{-- <td class="selectCheckbox"><input type="checkbox" name="selected_students[]"
                                value="{{ $student->id }}"></td> --}}
                        <td class="studentName">{{ $student->name }}</td>
                        <td class="rollNumber">{{ $student->rollnumber }}</td>
                        <td class="mobileNumber">{{ $student->mobile_number }}</td>
                        <td class="balance">৳{{ number_format($student->balance, 2) }}</td>
                        <td class="departmentName">{{ $student->department->department_name }}</td>
                        <!-- Assuming transactions and services are related to students -->
                        <td class="transactionDate">
                            @if ($student->transactions->isNotEmpty())
                                {{ $student->transactions->first()->date }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="transactionAmount">
                            @if ($student->transactions->isNotEmpty())
                                ৳{{ number_format($student->transactions->first()->amount, 2) }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td class="serviceName">
                            @if ($student->services)
                                {{ $student->services->first()->servicename ?? 'N/A' }}
                            @else
                                N/A
                            @endif
                        </td>


                        <td class="serviceQuantity">
                            @if ($student->services && $student->services->isNotEmpty())
                                {{ $student->services->first()->quantity ?? 'N/A' }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            @if ($students->total() > $students->perPage())
                {{ $students->links() }}
            @endif
        </div> --}}
    </div>
@endsection
