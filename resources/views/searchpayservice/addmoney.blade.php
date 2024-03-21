@extends('layouts.app-master')

@section('content')

    <div class="card border-2 my-4" style="margin: 35px; padding: 35px;">
        <div class="card-header">
            <h5 class="card-title text-white p-1">
                Pay For Services
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
            <form action="{{ route('searchpayservice.search') }}" method="GET" class="form-inline mb-3">
                @csrf <!-- Add CSRF token -->
                {{-- <div class="form-group rounded p-2">
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
                <div class="form-group rounded p-2">
                    <label for="searchInput" class="mr-2">Search Student Using Only Roll Number:</label>
                    <input type="text" name="search" id="searchInput" value="{{ $search }}"
                        placeholder="Search..." class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ url('/searchpayservice') }}">
                    <button type="button" class="btn btn-primary ml-2">Reset</button>
                </a>
            </form>
        </div>

        <!-- Display Pay for services dynamically Form for Selected Student -->
        @if ($search && count($students) > 0)
            <form action="{{ route('searchservice.execute') }}" method="post" class="row g-3 bg-dark p-4 rounded">
                @csrf <!-- Add CSRF token -->

                <!-- Display Student Information in a Table -->
                <div class="col-12">
                    <label class="form-label text-white">Student Information</label>
                    @if (count($students) > 0)
                        <table class="table table-bordered border-success">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
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
                        <div class="alert alert-danger"> <!-- Changed to red -->
                            No students found for the given search criteria.
                        </div>
                    @endif
                </div>

                <!-- Display service names along with prices in a Table -->
                <div class="col-12 mt-3">
                    {{-- <label class="form-label text-white">Service Prices</label> --}}
                    @if (count($services) > 0)
                        {{-- <table class="table table-bordered border-primary">
                            <thead>
                                <tr>
                                    <th scope="col">Service Name</th>
                                    <th scope="col">Service Description</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $service->servicename }}</td>
                                        <td>{{ $service->servicedescription }}</td>
                                        <td>৳{{ $service->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    @else
                        <div class="alert alert-warning"> <!-- Changed to yellow -->
                            No services found.
                        </div>
                    @endif
                </div>

                <!-- Date Input Field -->
                <div class="col-12">
                    <label for="date" class="form-label text-white">Date</label>
                    <input type="date" name="date" class="form-control" id="date" value="{{ date('Y-m-d') }}"
                        required readonly>
                </div>


                <!-- Add a hidden input field to pass $students data -->
                <input type="hidden" id="studentsData" value="{{ json_encode($students) }}">





                <!-- Add a button to trigger the dynamic form generation -->
                <div class="col-12 mt-3">
                    <button id="generateServicesForm" class="btn btn-primary">Generate Services Form</button>
                </div>


                <!-- Dynamic service fields based on available services -->
                <div class="col-12">
                    <div id="servicesFormContainer">
                        <!-- This is where the dynamically generated form fields for services will go -->
                    </div>
                </div>

                <!-- Hidden input field to store the transaction ID -->


                <input type="hidden" id="transactionId" name="transactionId" value="">


                <!-- Display current balance -->
                <div id="currentBalance"></div>

                <!-- Display total cost -->
                <div id="totalCost"></div>


                <div class="error-message" id="errorMessage"></div>
                <!-- Include Transactions View -->
                @include('searchpayservice.showtransactions')
            </form>
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

    <!-- Add JavaScript code to dynamically generate form fields -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentsData = JSON.parse(document.getElementById('studentsData').value);
            const servicesFormContainer = document.getElementById('servicesFormContainer');
            const currentBalanceElement = document.getElementById('currentBalance');
            const totalCostElement = document.getElementById('totalCost');
            const generateServicesFormButton = document.getElementById('generateServicesForm');
            const errorMessageElement = document.getElementById('errorMessage');

            let totalCost = 0;

            generateServicesFormButton.addEventListener('click', function() {
                servicesFormContainer.innerHTML = '';
                errorMessageElement.textContent = ''; // Clear error message

                // Dynamically generate form fields based on services
                const services = {!! json_encode($services) !!};
                let selectedServiceCount = 0;

                services.forEach(function(service) {
                    const label = document.createElement('label');
                    label.setAttribute('for', 'service_' + service.id);
                    label.className = 'form-label text-white';
                    label.textContent =
                        `${service.servicename} (Min Quantity: 0) Price: ৳${service.price}`;

                    const input = document.createElement('input');
                    input.setAttribute('type', 'number');
                    input.setAttribute('name',
                        `services[${service.id}]`); // Use array notation for multiple selections
                    input.setAttribute('data-price', service.price);
                    input.className = 'form-control';
                    input.id = 'service_' + service.id;
                    input.required = true;
                    input.min = 0; // Minimum selection
                    input.max = 100; // Maximum selection (change as needed)

                    // Append label and input to the container
                    servicesFormContainer.appendChild(label);
                    servicesFormContainer.appendChild(input);

                    // Calculate total cost dynamically
                    input.addEventListener('input', function() {
                        totalCost = calculateTotalCost();
                        updateTotalCostElement(totalCost);
                    });

                    // Count selected services
                    input.addEventListener('change', function() {
                        if (parseInt(input.value) > 0) {
                            selectedServiceCount++;
                        }
                    });
                });

                const payNowButton = document.createElement('button');
                payNowButton.setAttribute('type', 'button');
                payNowButton.className = 'btn btn-primary';
                payNowButton.textContent = 'Pay Now';

                payNowButton.addEventListener('click', async function() {
                    const balance = parseFloat(studentsData[0].balance);
                    const errorMessageElement = document.getElementById('errorMessage');

                    // Check if any service has a quantity greater than 0
                    const inputs = document.querySelectorAll('[name^="services["]');
                    let totalQuantity = 0;
                    inputs.forEach(function(input) {
                        const quantity = parseInt(input.value) || 0;
                        totalQuantity += quantity;
                    });

                    // If totalQuantity is 0, display an error message and return
                    if (totalQuantity === 0) {
                        errorMessageElement.textContent = 'Please select at least one service.';
                        errorMessageElement.style.color = 'red';
                        return;
                    }

                    try {
                        // Check if balance is sufficient
                        if (totalCost > balance) {
                            throw new Error('Recharge Account: Insufficient funds.');
                        }

                        // Generate transaction ID
                        const studentId = studentsData[0].id;
                        const transactionId = generateTransactionId(studentId).toString();

                        // Set transaction ID in the hidden input field
                        document.getElementById('transactionId').value = transactionId;

                        // Retrieve previous balance before the payment
                        const previousBalance = balance;

                        // Save transaction details for each service
                        await saveTransactionDetails(studentId, transactionId);

                        // Calculate updated balance after the payment
                        const updatedBalance = previousBalance - totalCost;

                        // Construct the success message with previous and updated balances
                        const successMessage =
                            'Payment Successful!<br>' +
                            'Previous Balance: ৳' + previousBalance.toFixed(2) + '<br>' +
                            'Updated Balance: ৳' + updatedBalance.toFixed(2);


                        // Display success message
                        errorMessageElement.innerHTML = successMessage;
                        errorMessageElement.style.color = 'green';

                    } catch (error) {
                        console.error('Payment error:', error.message);
                        errorMessageElement.textContent = error.message;
                        errorMessageElement.style.color = 'red';
                    }
                });

                // Append "Pay Now" button to the container
                servicesFormContainer.appendChild(payNowButton);

                // Update current balance and total cost elements
                updateCurrentBalanceElement(studentsData[0].balance);
                updateTotalCostElement(totalCost);
            });

            async function saveTransactionDetails(studentId, transactionId) {
                const saveTransactionUrl = '/save-transaction';
                const inputs = document.querySelectorAll('[name^="services["]');

                try {
                    // Loop through each service input
                    for (const input of inputs) {
                        const serviceId = input.name.match(/\[(\d+)\]/)[1];
                        const quantity = parseInt(input.value) || 0;

                        // Skip saving entry for services with quantity 0
                        if (quantity > 0) {
                            const price = parseFloat(input.getAttribute('data-price')) || 0;
                            const totalAmount = quantity * price;

                            // Construct transaction details
                            const transactionDetails = {
                                service_id: serviceId,
                                student_id: studentId,
                                transaction_id: transactionId,
                                quantity: quantity,
                                total_amount: totalAmount
                            };

                            // Make AJAX request to save transaction details
                            const response = await fetch(saveTransactionUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify(transactionDetails)
                            });

                            // Check if the response is successful
                            if (!response.ok) {
                                throw new Error(
                                    `Failed to save transaction details. Server returned status ${response.status}.`
                                );
                            }

                            // Parse response JSON
                            const responseData = await response.json();

                            // Check if the response indicates success
                            if (!responseData.success) {
                                throw new Error(responseData.message ||
                                    'Unknown error occurred while saving transaction details.');
                            }
                        }
                    }
                } catch (error) {
                    console.error('Save transaction error:', error);
                    throw new Error('Error saving transaction details. Please try again.');
                }
            }


            function calculateTotalCost() {
                const inputs = document.querySelectorAll('[name^="services["]');
                let totalCost = 0;

                inputs.forEach(function(input) {
                    const quantity = parseInt(input.value) || 0;
                    const price = parseFloat(input.getAttribute('data-price')) || 0;
                    totalCost += quantity * price;
                });

                return totalCost.toFixed(2);
            }

            function updateCurrentBalanceElement(balance) {
                currentBalanceElement.textContent = `Current Balance: ৳${balance}`;
            }

            function updateTotalCostElement(totalCost) {
                totalCostElement.textContent = `Total Cost: ৳${totalCost}`;
            }

            function generateTransactionId(studentId) {
                return studentId.toString(); // Convert student ID to string and return it as transaction ID
            }

        });
    </script>



@endsection
