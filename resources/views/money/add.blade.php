<!-- resources/views/money/add.blade.php -->

@extends('layouts.app-master')

@section('content')
    <div class="card border-2 my-4" style="margin: 20px; padding: 20px;">
        <div class="card-header">
            <h5 class="card-title">
                Add Money
            </h5>

        </div>


        <!-- Display success message if exists -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <form action="{{ route('money.add') }}" method="post" class="row g-3 bg-dark p-4 rounded">
            @csrf <!-- Add CSRF token -->

            <div class="col-12">
                <label for="student_id" class="form-label text-white">Student ID</label>
                <select name="student_id" class="form-select">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->id }})</option>
                    @endforeach
                </select>


            </div>
            <div class="col-12">
                <label for="date" class="form-label text-white">Date</label>
                <input type="date" name="date" class="form-control" id="date" required>
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
            <div class="col-12">
                <label for="transaction_type" class="form-label text-white">Transaction Type</label>
                <select name="transaction_type" class="form-select">
                    <option value="credit">Credit</option>
                    <option value="debit">Debit</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Add Money</button>
            </div>
        </form>

        @include('money.transactions')

    </div>
@endsection
