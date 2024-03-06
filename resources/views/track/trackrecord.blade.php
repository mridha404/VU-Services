@extends('layouts.app-master')

@section('content')
    <div class="container">
        <div class="card border-2 my-4" style="margin: 35px; padding: 35px;">
            <div class="card-header">
                <h5 class="card-title text-white p-1">
                    Student Track Records
                </h5>
            </div>

            <!-- Search Form -->
            <div class="col-md-6 mb-3">
                <form action="{{ route('trackrecord') }}" method="GET" class="form-inline mb-3">

                    <!-- Add CSRF token -->
                    @csrf

                    <div class="form-group rounded p-2">
                        <label for="searchInput" class="mr-2">Search Student Using Only Roll Number:</label>
                        <input type="text" name="search" id="searchInput" value="{{ isset($search) ? $search : '' }}"
                            placeholder="Search..." class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ url('/trackrecord') }}">
                        <button type="button" class="btn btn-primary ml-2">Reset</button>
                    </a>
                </form>
            </div>
        </div>



        @if (isset($studentTransactions))
            <!-- Display student transactions -->
            <div class="card border-2 my-4" style="margin: 35px; padding: 35px;">
                <div class="card-header">
                    <h5 class="card-title text-white p-1">
                        Student Transactions
                    </h5>
                </div>
                <div class="card-body">
                    @if ($studentTransactions->isEmpty())
                        <p>No transactions found.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>Service Name</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studentTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>{{ $transaction->service->servicename }}</td>
                                        <td>{{ $transaction->quantity }}</td>
                                        <td>{{ $transaction->total_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endif


    </div>

@endsection
