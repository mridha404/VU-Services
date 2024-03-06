<?php

// app/Http/Controllers/PaymentServicesController.php



namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Student;
use App\Models\Department;
use App\Models\Transaction;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentServicesController extends Controller
{
    public function showPaymentForm(Request $request)
    {
        $search = $request->input('general_search');
        $departmentId = $request->input('department_search');

        // Fetch services for dropdown
        $services = Service::all();

        // Fetch departments for dropdown
        $departments = Department::all();

        // Fetch students based on the provided search criteria
        $studentsQuery = Student::query();

        if ($search) {
            $studentsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('rollnumber', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('mobile_number', 'like', "%$search%");
            });
        }

        if ($departmentId) {
            $studentsQuery->where('department_id', $departmentId);
        }

        $students = $studentsQuery->get();

        return view('payforservices.pay', compact('services', 'students', 'departments'));
    }

    // public function processPayment(Request $request)
    // {
    //     // Validate the form data
    //     $validator = Validator::make($request->all(), [
    //         'student_id' => 'required|exists:students,id',
    //         'quantities' => 'required|array',
    //         'quantities.*' => 'integer|min:1',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('payforservices.pay')->withErrors($validator)->withInput();
    //     }

    //     // Access form data
    //     $studentId = $request->input('student_id');
    //     $quantities = $request->input('quantities', []);

    //     // Fetch the selected student
    //     $selectedStudent = Student::find($studentId);

    //     // Check if the selected student exists
    //     if (!$selectedStudent) {
    //         return redirect()->route('payforservices.pay')->with('error', 'Student not found.');
    //     }

    //     // Check if the selected student has a balance
    //     if ($selectedStudent->balance === null) {
    //         return redirect()->route('payforservices.pay')->with('error', 'Selected student has no balance.');
    //     }

    //     // Continue with the rest of your payment processing logic
    //     // ...

    //     // Use a database transaction for data consistency
    //     DB::beginTransaction();

    //     try {
    //         $previousBalance = $selectedStudent->balance;

    //         // Calculate the total cost based on quantities and service prices
    //         $totalCost = 0;
    //         $services = Service::all();

    //         foreach ($quantities as $index => $quantity) {
    //             $service = $services[$index];
    //             $totalCost += $quantity * $service->price;
    //         }

    //         // Check if the student has enough balance
    //         $remainingBalance = $previousBalance - $totalCost;

    //         // Fetch service names and quantities for display
    //         $serviceDetails = [];
    //         foreach ($quantities as $index => $quantity) {
    //             $service = $services[$index];
    //             $serviceDetails[] = [
    //                 'serviceName' => $service->servicename,
    //                 'serviceId' => $service->id,
    //                 'quantity' => $quantity,
    //             ];
    //         }

    //         if ($remainingBalance < 0) {
    //             return redirect()->route('payforservices.pay')->with('success', 'Insufficient funds. Please add money to your account!');
    //         }

    //         // Deduct the amount from the student's balance
    //         $selectedStudent->balance = $remainingBalance;
    //         $selectedStudent->save();

    //         // Commit the transaction
    //         DB::commit();

    //         // Return the result view with the calculated values
    //         return view('payforservices.result', compact('studentId', 'selectedStudent', 'serviceDetails', 'totalCost', 'remainingBalance', 'previousBalance'));
    //     } catch (\Exception $e) {
    //         // Rollback the transaction on error
    //         DB::rollBack();

    //         // Handle the exception (you can log or return an error view)
    //         return redirect()->route('payforservices.pay')->with('error', 'Payment processing failed. Please try again.');
    //     }
    // }

    // public function searchStudent(Request $request)
    // {
    //     $searchCriteria = $request->input('searchCriteria');

    //     // Implement your logic to fetch student information based on the search criteria
    //     // For example, assuming you have a Student model:
    //     $student = Student::where('name', 'like', "%$searchCriteria%")
    //         ->orWhere('rollnumber', 'like', "%$searchCriteria%")
    //         ->orWhere('email', 'like', "%$searchCriteria%")
    //         ->orWhere('mobile_number', 'like', "%$searchCriteria%")
    //         ->first();

    //     if ($student) {
    //         // Adjust the response structure based on your needs
    //         return response()->json([
    //             'success' => true,
    //             'data' => [
    //                 'name' => $student->name,
    //                 'email' => $student->email,
    //                 'rollnumber' => $student->rollnumber,
    //                 'mobile_number' => $student->mobile_number,
    //             ],
    //             // Assuming you have services related to the student
    //             'services' => $student->services,
    //         ]);
    //     } else {
    //         return response()->json(['success' => false]);
    //     }
    // }
}
