<?php

// app/Http/Controllers/MoneyController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Student;

class MoneyController extends Controller
{
    public function showForm()
    {
        $students = Student::all();
        $transactions = Transaction::with('student')->get();

        return view('money.add', ['students' => $students, 'transactions' => $transactions]);
    }

    public function addMoney(Request $request)
    {
        // Validation rules (your existing validation rules)
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:cash,card,bank',
            'transaction_type' => 'required|in:credit,debit',
        ]);

        // Begin a database transaction
        DB::beginTransaction();

        try {
            // Create a new transaction
            $transaction = Transaction::create([
                'student_id' => $request->input('student_id'),
                'date' => $request->input('date'),
                'amount' => $request->input('amount'),
                'payment_method' => $request->input('payment_method'),
                'transaction_type' => $request->input('transaction_type'),
                'status' => 'completed',
            ]);

            // Update the student's balance
            $student = Student::find($request->input('student_id'));
            $newBalance = ($request->input('transaction_type') === 'credit')
                ? $student->balance + $request->input('amount')
                : $student->balance - $request->input('amount');

            // Update the student's balance in the students table
            $student->update(['balance' => $newBalance]);

            // Commit the database transaction
            DB::commit();

            // Fetch all transactions for display
            $transactions = Transaction::with('student')->get();

            // Retrieve students again for the form
            $students = Student::all();

            // return view('money.add', ['students' => $students, 'transactions' => $transactions])
            //     ->with('success', 'Money added successfully!');
            
                return redirect()->route('money.add')->with('success', 'Money added successfully!');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();

            // Handle the exception (log, redirect, show error message, etc.)
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing the transaction.']);
        }
    }


    
}
