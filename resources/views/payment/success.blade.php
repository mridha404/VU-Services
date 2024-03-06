@extends('layouts.app-master')

@section('content')
    <div class="container">
        <h2 class="text-white mt-3">Payment Success</h2>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($transactions && count($transactions) > 0)
        
            <h3 class="mt-4 text-white">Money Transactions</h3>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Transaction Type</th>
                        <th>Status</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>
                                @php
                                    $student = \App\Models\Student::find($transaction->student_id);
                                    echo $student ? $student->name : 'N/A';
                                @endphp
                            </td>
                            <td>{{ $transaction->student_id }}</td>
                            <td>{{ $transaction->date }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->payment_method }}</td>
                            <td>{{ $transaction->transaction_type }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>{{ $transaction->student->balance }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-white mt-4">No transaction history found.</p>
        @endif
    </div>
@endsection
