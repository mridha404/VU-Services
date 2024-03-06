<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionHistory;
use App\Models\Service;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;



class SearchPayServiceController extends Controller
{
    // public function searchStudent(Request $request)
    // {
    //     $search = $request->input('search');
    //     $department = $request->input('department');

    //     $students = Student::where(function ($query) use ($search) {
    //         $query->where('rollnumber', 'like', "%$search%")
    //             ->orWhere('email', 'like', "%$search%")
    //             ->orWhere('rollnumber', 'like', "%$search%")
    //             ->orWhere('mobile_number', 'like', "%$search%");
    //     })
    //     ->when($department, function ($query) use ($department) {
    //         return $query->where('department_id', $department);
    //     })
    //     ->get();

    //     $departments = Department::all();
    //     $services = Service::all();

    //     return view('searchpayservice.addmoney', [
    //         'students' => $students,
    //         'search' => $search,
    //         'selectedDepartment' => $department,
    //         'departments' => $departments,
    //         'services' => $services,
    //     ]);
    // }

    //code changed on 07-02-2024

    public function searchStudent(Request $request)
    {
        $search = $request->input('search');
        $department = $request->input('department');

        $students = Student::query()
            ->when($search, function ($query, $search) {
                return $query->where('rollnumber', '=', $search);
            })
            ->when($department, function ($query, $department) {
                return $query->where('department_id', $department);
            })
            ->get();

        $departments = Department::all();
        $services = Service::all();

        return view('searchpayservice.addmoney', [
            'students' => $students,
            'search' => $search,
            'selectedDepartment' => $department,
            'departments' => $departments,
            'services' => $services,
        ]);
    }



    public function searchPayService(Request $request)
    {
        $services = Service::all(); // Adjust the query as needed based on your model

        // Debugging line
        // dd($services);

        // return view('searchservice.execute', [

        //     'search' => $request->input('search'),

        //     'services' => $services,
        // ]);
    }

    public function updateBalance($studentId, $amount)
    {
        try {
            // Create a new transaction record
            $transaction = new Transaction();
            $transaction->student_id = $studentId;
            $transaction->amount = $amount;
            $transaction->payment_method = 'cash'; // You can adjust this based on your requirements
            $transaction->transaction_type = 'debit'; // Represents deduction from the student's account balance
            $transaction->status = 'completed'; // or 'completed', depending on your logic
            $transaction->date = now(); // You can adjust this based on your requirements
            $transaction->save();

            // Update the student's balance
            $student = Student::find($studentId);
            if (!$student) {
                return response()->json(['error' => 'Student not found'], 404);
            }
            $student->balance -= $amount;
            $student->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    // public function saveTransaction(Request $request)
    // {

    //     try {
    //         $data = $request->validate([
    //             'service_id' => 'required|integer',
    //             'transaction_id' => 'required|string',
    //             'quantity' => 'required|integer',
    //             'total_amount' => 'required|numeric',
    //         ]);

    //         // Assuming your TransactionHistory model has the corresponding attributes
    //         TransactionHistory::create($data);
    //         Log::info('Transaction data:', $data);

    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         // Log the error or handle it as needed
    //         Log::error('Error saving transaction details: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'error' => $e->getMessage()]);
    //     }
    // }

    //code chnaged on 08-02-2024




    public function saveTransaction(Request $request)
    {
        try {
            // Generate a new unique transaction ID
            $transaction_id = Str::uuid()->toString(); // Ensure the UUID is converted to a string

            // Extract other data from the request
            $data = $request->all();

            // Assign the generated ID to the 'transaction_id' field
            $data['transaction_id'] = $transaction_id;

            // Log the received data
            Log::info('Received transaction data:', $data);

            // Validate the data
            $validatedData = $request->validate([
                'service_id' => 'required|integer',
                'student_id' => 'required|integer',
                'transaction_id' => 'required|string', // Ensure transaction_id is present and is a string
                'quantity' => 'required|integer',
                'total_amount' => 'required|numeric',
            ]);

            // Save transaction details
            TransactionHistory::create($validatedData);
            Log::info('Transaction data saved:', $validatedData);

            // Retrieve student's previous balance
            $student = Student::findOrFail($validatedData['student_id']);
            $previous_balance = $student->balance;

            // Calculate updated balance after the payment
            $updated_balance = $previous_balance - $validatedData['total_amount'];

            // Update student's balance
            $student->update(['balance' => $updated_balance]);

            // Display success message with previous and updated balances
            $message = 'Payment successful! Previous balance: $' . $previous_balance . ', Updated balance: $' . $updated_balance;
            Log::info($message);

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error('Error saving transaction details: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
