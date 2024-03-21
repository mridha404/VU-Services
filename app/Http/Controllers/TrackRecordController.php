<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\TransactionHistory;

class TrackRecordController extends Controller
{
    public function index()
    {
        return view('track.trackrecord');
    }

    public function search(Request $request)
    {
        // Validate the roll number input
        $request->validate([
            'search' => 'required|string|max:255',
        ]);

        // Find the student by roll number
        $student = Student::where('rollnumber', $request->search)->first();

        // If student not found, return with message
        if (!$student) {
            return back()->with('error', 'No student found for the given roll number.');
        }

        // Retrieve transactions for the student
        $studentTransactions = TransactionHistory::where('transaction_id', $student->id)->get();


        // Pass the data to the view
        return view('track.trackrecord', compact('studentTransactions'));
    }
}
