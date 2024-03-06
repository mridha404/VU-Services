@extends('layouts.app-master')

@section('content')
    <h1 class="p-2 rounded m-4" style="font-size: 1.5rem;">Students Services Report Generation Builder</h1>

    <!-- Container for the buttons and dropdowns -->
    <div class="btn-container p-2 border border-gray-200 rounded mt-2 mb-2 m-4 d-flex justify-content-between">
        <!-- Button group for selecting columns -->
        <div class="btn-group me-2" role="group" aria-label="Select Columns">
            <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownSelect" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Select Columns
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownSelect">
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="studentNameCheckbox" name="studentNameCheckbox"
                        value="studentName">
                    <label class="form-check-label" for="studentNameCheckbox">Student Name</label>
                </li>
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="rollNumberCheckbox" name="rollNumberCheckbox"
                        value="rollNumber">
                    <label class="form-check-label" for="rollNumberCheckbox">Roll Number</label>
                </li>
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="mobileNumberCheckbox" name="mobileNumberCheckbox"
                        value="mobileNumber">
                    <label class="form-check-label" for="mobileNumberCheckbox">Mobile Number</label>
                </li>
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="balanceCheckbox" name="balanceCheckbox"
                        value="balance">
                    <label class="form-check-label" for="balanceCheckbox">Balance</label>
                </li>
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="departmentNameCheckbox"
                        name="departmentNameCheckbox" value="departmentName">
                    <label class="form-check-label" for="departmentNameCheckbox">Department Name</label>
                </li>
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="transactionDateCheckbox"
                        name="transactionDateCheckbox" value="transactionDate">
                    <label class="form-check-label" for="transactionDateCheckbox">Transaction Date</label>
                </li>
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="transactionAmountCheckbox"
                        name="transactionAmountCheckbox" value="transactionAmount">
                    <label class="form-check-label" for="transactionAmountCheckbox">Transaction Amount</label>
                </li>
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="serviceNameCheckbox" name="serviceNameCheckbox"
                        value="serviceName">
                    <label class="form-check-label" for="serviceNameCheckbox">Service Name</label>
                </li>
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="servicePriceCheckbox" name="servicePriceCheckbox"
                        value="servicePrice">
                    <label class="form-check-label" for="servicePriceCheckbox">Service Price</label>
                </li>
                <li class="form-check">
                    <input type="checkbox" class="form-check-input" id="serviceQuantityCheckbox"
                        name="serviceQuantityCheckbox" value="serviceQuantity">
                    <label class="form-check-label" for="serviceQuantityCheckbox">Service Quantity</label>
                </li>

            </ul>
        </div>



        <!-- Print button -->
        <button class="btn btn-outline-success" type="button" onclick="printTable()">
            Print
        </button>
        <div style="margin-right: 10px;"></div>

        <!-- Button group for export options -->
        <div class="btn-group " role="group" aria-label="Export Options">
            <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownExport"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Export
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownExport">
                <li><a class="dropdown-item" href="{{ route('export.excel') }}" onclick="exportToExcel()">Excel</a></li>
                <li><a class="dropdown-item" href="{{ route('export.csv') }}" onclick="exportToCsv()">CSV</a></li>
                <li><a class="dropdown-item" href="{{ route('export.pdf') }}" onclick="exportToPdf()">PDF</a></li>
            </ul>
        </div>

        <!-- Show Entries dropdown -->
        <div class="btn-group ms-auto" role="group" aria-label="Show Entries">
            <select class="form-select" id="showEntries" onchange="updateEntries()">
                <option value="0">Show Entries</option>
                <option value="1">1</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="-1">All</option>
            </select>
        </div>
    </div>



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
                            <a href="{{ url('/generate-report') }}" class="mt-3">
                                <button type="button" class="btn btn-outline-success">Reset</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="my-4">
        <!-- Row for export buttons -->
        <form id="exportForm" method="POST" action="{{ route('export-report') }}">
            @csrf
            <input type="hidden" name="export_format" id="exportFormatInput">

            <button type="button" class="btn btn-outline-primary mx-1" onclick="exportToExcel()">Export to
                Excel</button>
            <button type="button" class="btn btn-outline-primary mx-1" onclick="exportToCSV()">Export to CSV</button>
            <button type="button" class="btn btn-outline-primary mx-1" onclick="exportToPDF()">Export to PDF</button>

        </form>




    </div>


    <div class="table-container mt-4 mb-4 ml-2 mr-2">
        <table class="table table-bordered border-success">
            <thead>
                <tr>
                    <th class="text-success selectCheckbox">Select</th>
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
                        <td class="selectCheckbox"><input type="checkbox" name="selected_students[]"
                                value="{{ $student->id }}"></td>
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

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            @if ($students->total() > $students->perPage())
                {{ $students->links() }}
            @endif
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"
        integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var dropdownColumns = new bootstrap.Dropdown(document.getElementById('dropdownSelect'));
            var dropdownExport = new bootstrap.Dropdown(document.getElementById('dropdownExport'));

            // Handle dropdown item clicks
            document.querySelectorAll('.dropdown-menu .form-check-input').forEach(function(checkboxItem) {
                checkboxItem.addEventListener('change', function(event) {
                    event
                        .stopPropagation(); // Prevent dropdown from closing when clicking on checkbox

                    updateTableColumns();
                    // Update the checkbox label color based on the checkbox state
                    if (this.checked) {
                        checkboxItem.nextElementSibling.classList.add(
                            'text-success'); // Add success color when checked
                    } else {
                        checkboxItem.nextElementSibling.classList.remove(
                            'text-success'); // Remove success color when unchecked
                    }
                });
            });
        });

        function printTable() {
            // Get the table element
            var table = document.querySelector('.table-container table');

            // Clone the table element
            var clonedTable = table.cloneNode(true);
            1

            // Create a new window for printing
            var printWindow = window.open('', '_blank');

            // Write the cloned table to the new window
            printWindow.document.write('<html><head><title>Print Table</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('table { border-collapse: collapse; width: 100%; }');
            printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
            printWindow.document.write('th { background-color: #f2f2f2; }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h2>Table to Print</h2>');
            printWindow.document.write(clonedTable.outerHTML);
            printWindow.document.write('</body></html>');

            // Close the document
            printWindow.document.close();

            // Print the new window
            printWindow.print();
        }




        function updateTableColumns() {
            var selectedCheckboxes = document.querySelectorAll('.dropdown-menu .form-check-input:checked');

            // Hide all table headers and cells by default
            var tableHeaders = document.querySelectorAll('.table thead th');
            var tableCells = document.querySelectorAll('.table tbody tr td');
            tableHeaders.forEach(function(header) {
                header.classList.add('d-none');
            });
            tableCells.forEach(function(cell) {
                cell.classList.add('d-none');
            });

            // Show selected column header and cells
            selectedCheckboxes.forEach(function(checkbox) {
                var selectedColumn = checkbox.value;
                var tableHeader = document.querySelector('.table thead th.' + selectedColumn);
                var tableColumn = document.querySelectorAll('.table tbody tr .' + selectedColumn);
                tableHeader.classList.remove('d-none');
                tableColumn.forEach(function(cell) {
                    cell.classList.remove('d-none');
                });
            });
        }

        // function exportToExcel() {
        //     // Get the table element
        //     var table = document.querySelector('.table');

        //     // Create a new workbook
        //     var wb = XLSX.utils.book_new();

        //     // Convert all columns to worksheet
        //     var ws = XLSX.utils.table_to_sheet(table);

        //     // Add the worksheet to the workbook
        //     XLSX.utils.book_append_sheet(wb, ws, 'Students Report');

        //     // Save the workbook as Excel file
        //     XLSX.writeFile(wb, 'students_report.xlsx');
        // }


        // function exportToCsv() {
        //     // Add your CSV export logic here
        //     console.log('Exporting to CSV...');
        // }





        document.getElementById("showEntries").addEventListener("change", function() {
            var selectedValue = this.value;
            if (selectedValue !== "0") {
                updateEntries();
            }
            // Optionally, you can reset the dropdown to "Show Entries" after selection
            this.value = "0";
        });


        // Function to update the number of entries displayed in the table
        function updateEntries() {
            var selectedValue = document.getElementById("showEntries").value;
            var tableRows = document.querySelectorAll('.table tbody tr');

            // Show all table rows
            tableRows.forEach(function(row) {
                row.classList.remove('d-none');
            });

            // Hide rows based on the selected value
            if (selectedValue !== "-1") { // If not selecting "All"
                var rowsToDisplay = selectedValue;
                var count = 0;

                // Hide rows after the selected number of entries
                tableRows.forEach(function(row) {
                    if (count >= rowsToDisplay) {
                        row.classList.add('d-none');
                    }
                    count++;
                });
            }
        }

        function exportToExcel() {
            window.location.href = "{{ route('export.excel') }}";
        }

        function exportToCSV() {
            window.location.href = "{{ route('export.csv') }}";
        }

        function exportToPDF() {
            window.location.href = "{{ route('export.pdf') }}";
        }
    </script>
@endsection
