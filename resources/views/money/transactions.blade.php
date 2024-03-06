<!-- resources/views/money/transactions.blade.php -->

@if($transactions && count($transactions) > 0)
    <h3 class="mt-4 text-white">Money Transactions</h3>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Transaction Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->student_id }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->payment_method }}</td>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td>{{ $transaction->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
