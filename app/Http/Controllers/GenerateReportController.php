<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\transactionhistory;
use App\Exports\StudentsExport;
use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Options;

class GenerateReportController extends Controller
{
    public function generateReport(Request $request)
    {
        // Fetch data from database
        $departments = Department::all();

        // Query students based on the selected department and roll number
        $query = Student::with(['department', 'transactions', 'transactionHistory.service']);

        // Retrieve selected department and roll number from the request
        $selectedDepartment = $request->input('department');
        $rollNumber = $request->input('rollNumber');

        if ($selectedDepartment) {
            $query->where('department_id', $selectedDepartment);
        }

        if ($rollNumber) {
            $query->where('rollnumber', '=', $rollNumber);
        }

        // Paginate the query result
        $students = $query->paginate(8); // Adjust the number as per your requirement

        // Pass data to the view
        return view('generatereport.report', compact('students', 'selectedDepartment', 'departments', 'rollNumber'));
    }



    // public function exportToPDF()
    // {
    //     // Fetch student data from the database
    //     $students = Student::all();

    //     // Pass the student data to the PDF view
    //     $data = [
    //         'title' => 'Students Report',
    //         'students' => $students,
    //     ];

    //     // Load the PDF view file
    //     $html = view('exports.students_pdf', $data)->render();

    //     // Create a new instance of Dompdf
    //     $dompdf = new Dompdf();

    //     // Load HTML content into Dompdf
    //     $dompdf->loadHtml($html);

    //     // (Optional) Set paper size and orientation
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Render the PDF
    //     $dompdf->render();

    //     // Output the generated PDF to the browser
    //     return $dompdf->stream('students_report.pdf');
    // }



    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    public function exportToCSV()
    {
        return Excel::download(new StudentsExport, 'students.csv');
    }



    public function exportToPDF()
    {
        // Retrieve student data from the database
        $students = Student::all();

        // HTML content for the PDF
        $html = '<style>';
        $html .= 'table { border-collapse: collapse; width: 100%; }';
        $html .= 'th, td { border: 1px solid #000; padding: 8px; }'; // You can adjust border and padding as needed
        $html .= '</style>';
        $html .= '<table>';
        $html .= '<thead><tr><th>Student Name</th><th>Roll Number</th><th>Mobile Number</th><th>Balance</th><th>Department Name</th></tr></thead>';
        $html .= '<tbody>';

        foreach ($students as $student) {
            $html .= '<tr>';
            $html .= '<td>' . $student->name . '</td>';
            $html .= '<td>' . $student->rollnumber . '</td>';
            $html .= '<td>' . $student->mobile_number . '</td>';

            // Apply different styles based on balance
            $balance = $student->balance;
            if ($balance < 0) {
                $html .= '<td style="color: red;">' . $balance . '</td>';
            } else {
                $html .= '<td>' . $balance . '</td>';
            }

            $html .= '<td>' . $student->department->department_name . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // Create options for Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Instantiate Dompdf with options
        $dompdf = new Dompdf($options);

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Stream the PDF to the client for download
        return $dompdf->stream('students.pdf');
    }
}
