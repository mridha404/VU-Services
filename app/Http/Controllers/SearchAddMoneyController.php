<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class SearchAddMoneyController extends Controller
{

    // public function searchStudent(Request $request)
    // {
    //     // Retrieve search criteria from the request
    //     $search = $request->input('search');
    //     $department = $request->input('department');

    //     // Your logic to retrieve students based on search criteria
    //     $students = Student::where(function ($query) use ($search) {
    //         $query->where('name', 'like', "%$search%")
    //             ->orWhere('email', 'like', "%$search%")
    //             ->orWhere('rollnumber', 'like', "%$search%")
    //             ->orWhere('mobile_number', 'like', "%$search%");
    //     })
    //         ->when($department, function ($query) use ($department) {
    //             return $query->where('department_id', $department);
    //         })
    //         ->get();

    //     // Your logic to retrieve departments
    //     $departments = Department::all();

    //     return view('searchadd.addmoney', ['students' => $students, 'search' => $search, 'selectedDepartment' => $department, 'departments' => $departments]);
    // }

    //new code on 07-02-2024

    public function searchStudent(Request $request)
    {
        // Retrieve search criteria from the request
        $search = $request->input('search');
        $department = $request->input('department');

        // Your logic to retrieve students based on search criteria
        $students = Student::where('rollnumber', '=', $search)->get();

        // Your logic to retrieve departments
        $departments = Department::all();

        return view('searchadd.addmoney', ['students' => $students, 'search' => $search, 'selectedDepartment' => $department, 'departments' => $departments]);
    }



    public function searchaddMoney(Request $request)
    {
        // Validation rules (adjust as needed)
        $request->validate([
            // 'date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:cash,card,bank',
            'transaction_type' => 'required|in:credit,debit',
        ]);

        // Begin a database transaction
        DB::beginTransaction();

        try {
            // Retrieve students from the hidden input field
            $students = json_decode($request->input('students'));

            // Retrieve the student's previous balance before the transaction
            $previousBalance = $students[0]->balance;

            // Create a new transaction
            $transaction = Transaction::create([
                'student_id' => $students[0]->id,
                'date' => $request->input('date'),
                'amount' => $request->input('amount'),
                'payment_method' => $request->input('payment_method'),
                'transaction_type' => $request->input('transaction_type'),
                'status' => 'completed',
            ]);

            // Update the student's balance
            $student = Student::find($students[0]->id);
            $newBalance = ($request->input('transaction_type') === 'credit')
                ? $student->balance + $request->input('amount')
                : $student->balance - $request->input('amount');

            // Update the student's balance in the students table
            $student->update(['balance' => $newBalance]);

            // Commit the database transaction
            DB::commit();

            // Fetch all transactions for display
            $transactions = Transaction::with('student')->get();

            // Redirect to the search page with data
            return redirect()->route('searchaddmoney.search')->with([
                'students' => $students,
                'transactions' => $transactions,
                'success' => 'Money added successfully!',
                'previousBalance' => $previousBalance,
                'updatedBalance' => $newBalance,
            ]);
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();

            // Handle the exception (log, redirect, show error message, etc.)
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing the transaction.']);
        }
    }
}
