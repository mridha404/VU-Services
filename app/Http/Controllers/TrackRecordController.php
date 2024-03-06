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

class TrackRecordController extends Controller
{
    public function trackrecord(Request $request)
    {
        // Retrieve the roll number input from the request
        $rollNumber = $request->input('rollnumber');

        // Retrieve the student's transactions with associated service details from the database
        $studentTransactions = TransactionHistory::whereHas('service', function ($query) {
            $query->select('id', 'servicename'); // select only necessary fields from services table
        })
            ->whereHas('transaction', function ($query) use ($rollNumber) {
                $query->whereHas('student', function ($query) use ($rollNumber) {
                    $query->where('rollnumber', $rollNumber);
                });
            })
            ->select('id', 'service_id', 'transaction_id', 'quantity', 'total_amount', 'created_at')
            ->with(['service:id,servicename']) // eager load service details
            ->get();

        // Pass the retrieved transactions to the view
        return view('track.trackrecord', compact('studentTransactions'));
    }
}
