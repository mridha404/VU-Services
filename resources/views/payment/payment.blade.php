{{-- <!-- resources/views/payment.blade.php -->

@extends('layouts.app-master')

@section('content')
<div class="container text-white">
    <h2 class="mt-3 mb-3">Payment</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('payment.process') }}">
        @csrf
         
        <div class="col-12">
            <label for="student_id" class="form-label text-white">Student ID</label>
            <select name="student_id" class="form-select">
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->id }})</option>
                @endforeach
            </select>
        </div>

        
         <!-- Display balance -->
         <div class="mb-3">
            <label for="balance" class="form-label">Current Balance</label>
            <input type="text" class="form-control" id="balance" value="{{ $student->balance }}" readonly>
        </div>

        <div class="mb-3">
            <label for="photocopy_quantity" class="form-label">Photocopy Quantity</label>
            <input type="number" class="form-control" name="photocopy_quantity" id="photocopy_quantity" min="1" required>
        </div>

        <div class="mb-3">
            <label for="print_quantity" class="form-label">Print Quantity</label>
            <input type="number" class="form-control" name="print_quantity" id="print_quantity" min="1" required>
        </div>

        <div class="mb-3">
            <label for="bus_services_quantity" class="form-label">Bus Services Duration (in months)</label>
            <input type="number" class="form-control" name="bus_services_quantity" id="bus_services_quantity" min="1" required>
        </div>

        <div class="mb-3">
            <label for="color_grayscale" class="form-label">Color/Grayscale</label>
            <select class="form-select" name="color_grayscale" id="color_grayscale" required>
                <option value="color">Color</option>
                <option value="grayscale">Grayscale</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="paymentMethod" class="form-label">Payment Method</label>
            <select class="form-select" name="paymentMethod" id="paymentMethod" required>
                <option value="bkash">bKash</option>
                <!-- Add other payment methods if needed -->
            </select>
        </div>

        <div class="mb-3">
            <label for="totalAmount" class="form-label">Total Amount</label>
            <input type="text" class="form-control" id="totalAmount" readonly>
        </div>

        


        <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form>
</div>

<script>
    // Calculate total amount based on user input
    document.addEventListener("input", function () {
        // Fixed prices per page
        const photocopyPrice = 5;
        const colorPrintPrice = 10;
        const grayscalePrintPrice = 5;
        const busServicePricePerMonth = 100;

        // Retrieve user inputs
        const photocopyQuantity = document.getElementById("photocopy_quantity").value;
        const printQuantity = document.getElementById("print_quantity").value;
        const busServicesDuration = document.getElementById("bus_services_quantity").value;
        const colorGrayscale = document.getElementById("color_grayscale").value;

        // Calculate total amount
        const totalAmount =
            photocopyQuantity * photocopyPrice +
            (colorGrayscale === "color" ? printQuantity * colorPrintPrice : printQuantity * grayscalePrintPrice) +
            busServicesDuration * busServicePricePerMonth;

        // Display total amount
        document.getElementById("totalAmount").value = totalAmount.toFixed(2); // Displaying two decimal places
    });
</script>
@endsection --}}





<!-- resources/views/payment/payment.blade.php -->

{{-- @extends('layouts.app-master')

@section('content')
    <div class="card border-0">
        <div class="card-header">
            <h5 class="card-title">
                Payment
            </h5>

        </div>

        <!-- Display success message if exists -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <form method="post" action="{{ route('payment.process') }}">
            @csrf

            <div class="col-12">
                <label for="student_id" class="form-label text-white">Student ID</label>
                <select name="student_id" class="form-select" id="student_id">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" data-balance="{{ $student->balance }}">{{ $student->name }}
                            ({{ $student->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <label for="photocopy_quantity" class="form-label text-white">Photocopy Quantity</label>
                <input type="number" class="form-control" name="photocopy_quantity" id="photocopy_quantity" min="1"
                    required>
            </div>
            <div class="col-12">
                <label for="print_quantity" class="form-label text-white">Print Quantity</label>
                <input type="number" class="form-control form-control-sm" name="print_quantity" id="print_quantity" min="1" required>
            </div>
            
            <div class="col-12">
                <label for="bus_services_quantity" class="form-label text-white">Bus Services Duration (in months)</label>
                <input type="number" class="form-control form-control-sm" name="bus_services_quantity" id="bus_services_quantity" min="1" required>
            </div>
            
            <div class="col-12">
                <label for="color_grayscale" class="form-label text-white">Color/Grayscale</label>
                <select class="form-select form-select-sm" name="color_grayscale" id="color_grayscale" required>
                    <option value="color">Color</option>
                    <option value="grayscale">Grayscale</option>
                </select>
            </div>
            
            <div class="col-12">
                <label for="payment_method" class="form-label text-white">Payment Method</label>
                <select class="form-select form-select-sm" name="payment_method" id="payment_method" required>
                    <option value="bkash">bKash</option>
                    <!-- Add other payment methods if needed -->
                </select>
            </div>
            
            <div class="col-12">
                <label for="totalAmount" class="form-label text-white">Total Amount</label>
                <input type="text" class="form-control form-control-sm" id="totalAmount" name="totalAmount" readonly>
            </div>
            
            <!-- Hidden input for totalAmount -->
            <input type="hidden" name="totalAmount" id="hiddenTotalAmount">
            
            <div class="col-12">
                <label for="balance" class="form-label text-white">Current Balance</label>
                <input type="text" class="form-control form-control-sm" id="balance" readonly>
            </div>
            

            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>

    <script>
        // Calculate total amount and update balance based on selected student
        document.addEventListener("input", function() {
            // Fixed prices per page
            const photocopyPrice = 5;
            const colorPrintPrice = 10;
            const grayscalePrintPrice = 5;
            const busServicePricePerMonth = 100;

            // Retrieve user inputs
            const photocopyQuantity = document.getElementById("photocopy_quantity").value;
            const printQuantity = document.getElementById("print_quantity").value;
            const busServicesDuration = document.getElementById("bus_services_quantity").value;
            const colorGrayscale = document.getElementById("color_grayscale").value;
            const studentId = document.getElementById("student_id").value;
            const studentBalance = document.getElementById("student_id").selectedOptions[0].getAttribute(
                "data-balance");

            // Calculate total amount
            const totalAmount =
                photocopyQuantity * photocopyPrice +
                (colorGrayscale === "color" ? printQuantity * colorPrintPrice : printQuantity *
                    grayscalePrintPrice) +
                busServicesDuration * busServicePricePerMonth;

            // Display total amount
            document.getElementById("totalAmount").value = totalAmount.toFixed(2); // Displaying two decimal places

            // Update hidden input for totalAmount
            document.getElementById("hiddenTotalAmount").value = totalAmount.toFixed(2);

            // Display balance based on selected student
            document.getElementById("balance").value = studentBalance;
        });
    </script>
@endsection --}}
@extends('layouts.app-master')

@section('content')
    <div class="card border-2 my-4" style="margin: 35px; padding: 35px;">
        <div class="card-header" >
            <h5 class="card-title text-white  p-1">
                Payment
            </h5>

        </div>


        <!-- Display success message if exists -->

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('payment.process') }}" method="post" class="row g-3 bg-dark p-4 rounded">
            @csrf <!-- Add CSRF token -->

            <div class="col-12">
                <label for="student_id" class="form-label text-white">Student ID</label>
                <select name="student_id" class="form-select" id="student_id">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" data-balance="{{ $student->balance }}">{{ $student->name }}
                            ({{ $student->id }})
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-12">
                <label for="photocopy_quantity" class="form-label text-white">Photocopy Quantity</label>
                <input type="number" class="form-control" name="photocopy_quantity" id="photocopy_quantity" min="1"
                    required>
            </div>
            <div class="col-12">
                <label for="print_quantity" class="form-label text-white">Print Quantity</label>
                <input type="number" class="form-control form-control-sm" name="print_quantity" id="print_quantity"
                    min="1" required>
            </div>

            <div class="col-12">
                <label for="bus_services_quantity" class="form-label text-white">Bus Services Duration (in months)</label>
                <input type="number" class="form-control form-control-sm" name="bus_services_quantity"
                    id="bus_services_quantity" min="1" required>
            </div>

            <div class="col-12">
                <label for="color_grayscale" class="form-label text-white">Color/Grayscale</label>
                <select class="form-select form-select-sm" name="color_grayscale" id="color_grayscale" required>
                    <option value="color">Color</option>
                    <option value="grayscale">Grayscale</option>
                </select>
            </div>

            <div class="col-12">
                <label for="payment_method" class="form-label text-white">Payment Method</label>
                <select class="form-select form-select-sm" name="payment_method" id="payment_method" required>
                    <option value="bkash">bKash</option>
                    <!-- Add other payment methods if needed -->
                </select>
            </div>

            <div class="col-12">
                <label for="totalAmount" class="form-label text-white">Total Amount</label>
                <input type="text" class="form-control form-control-sm" id="totalAmount" name="totalAmount" readonly>
            </div>

            <!-- Hidden input for totalAmount -->
            <input type="hidden" name="totalAmount" id="hiddenTotalAmount">

            <div class="col-12">
                <label for="balance" class="form-label text-white">Current Balance</label>
                <input type="text" class="form-control form-control-sm" id="balance" readonly>
            </div>


            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit Payment</button>
            </div>

        </form>

        <script>
            // Calculate total amount and update balance based on selected student
            document.addEventListener("input", function() {
                // Fixed prices per page
                const photocopyPrice = 5;
                const colorPrintPrice = 10;
                const grayscalePrintPrice = 5;
                const busServicePricePerMonth = 100;

                // Retrieve user inputs
                const photocopyQuantity = document.getElementById("photocopy_quantity").value;
                const printQuantity = document.getElementById("print_quantity").value;
                const busServicesDuration = document.getElementById("bus_services_quantity").value;
                const colorGrayscale = document.getElementById("color_grayscale").value;
                const studentId = document.getElementById("student_id").value;
                const studentBalance = document.getElementById("student_id").selectedOptions[0].getAttribute(
                    "data-balance");

                // Calculate total amount
                const totalAmount =
                    photocopyQuantity * photocopyPrice +
                    (colorGrayscale === "color" ? printQuantity * colorPrintPrice : printQuantity *
                        grayscalePrintPrice) +
                    busServicesDuration * busServicePricePerMonth;

                // Display total amount
                document.getElementById("totalAmount").value = totalAmount.toFixed(2); // Displaying two decimal places

                // Update hidden input for totalAmount
                document.getElementById("hiddenTotalAmount").value = totalAmount.toFixed(2);

                // Display balance based on selected student
                document.getElementById("balance").value = studentBalance;
            });
        </script>



    </div>
@endsection
