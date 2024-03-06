<?php

// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        $students = Student::all();

        return view('payment.payment', ['students' => $students]);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'photocopy_quantity' => 'required|integer|min:1',
            'print_quantity' => 'required|integer|min:1',
            'bus_services_quantity' => 'required|integer|min:1',
            'color_grayscale' => 'required|in:color,grayscale',
            'payment_method' => 'required|in:bkash', // Add other payment methods if needed
            'totalAmount' => 'required|numeric|min:0.01',
        ]);
    
        $student = Student::find($request->input('student_id'));
    
        if (!$student) {
            return redirect()->route('payment.show')->with('error', 'Student not found. Please try again or add money to your account.');
        }
    
        if ($student->balance < $request->input('totalAmount')) {
            return redirect()
                ->route('payment.show')
                ->withErrors(['error' => 'Insufficient balance. Please add money to your account.'])
                ->withInput();
        }
        
    
        // Deduct the amount from the student's balance
        $student->balance -= $request->input('totalAmount');
        $student->save();
    
        // Create a transaction record
        Transaction::create([
            'student_id' => $student->id,
            'date' => now(),
            'amount' => $request->input('totalAmount'),
            'payment_method' => $request->input('payment_method'),
            'transaction_type' => 'debit',
            'status' => 'completed',
        ]);
    
        // Redirect to the success page with the updated balance
        return redirect()->route('payment.success', ['student' => $student])
            ->with('success', 'Payment successful. Updated balance: ' . $student->balance);
    }
    
    
    public function showTransactionHistoryOnSuccess(Student $student)
    {
        $transactions = $student->transactions;

        return view('payment.success', ['student' => $student, 'transactions' => $transactions]);
    }
}







      