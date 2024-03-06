<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\transactionhistory;
use App\Exports\StudentsExport;

use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Options;
use App\Exports\AllStudentsExport;
use App\Exports\SelectedStudentsExport;
use Pdf;

class ReportController extends Controller
{
    public function showReportGenerationForm(Request $request)
    {
        // Fetch necessary data for the form
        $departments = Department::all();
        $selectedDepartment = $request->get('department');
        $selectedRollNumber = $request->get('rollNumber');

        // Retrieve students based on filters and pagination
        $students = Student::query()
            ->when($selectedDepartment, function ($query) use ($selectedDepartment) {
                $query->where('department_id', $selectedDepartment);
            })
            ->when($selectedRollNumber, function ($query) use ($selectedRollNumber) {
                $query->where('rollnumber', $selectedRollNumber);
            })
            ->get(); // Fetch all students matching the conditions

        if ($request->export) {
            return Excel::download(new AllStudentsExport($students), 'all_students.xlsx');
        }    ///important written by kabbo sir on 20-02-2024


        if ($request->csv) {
            return Excel::download(new AllStudentsExport($students), 'all_students.csv', \Maatwebsite\Excel\Excel::CSV);
        }

        if ($request->pdf) {
        }


        return view('generatereport.newreport', [
            'departments' => $departments,
            'selectedDepartment' => $selectedDepartment,
            'selectedRollNumber' => $selectedRollNumber,
            'students' => $students,
        ]);
    }



    public function exportSelectedStudents(Request $request)
    {
        // Validate selected student IDs
        $request->validate([
            'selected_students' => 'required|array'
        ]);

        $selectedStudents = Student::whereIn('id', $request->input('selected_students'))->get();

        if ($selectedStudents->isEmpty()) {
            return abort(404, 'No students were selected for export.');
        }

        return Excel::download(new SelectedStudentsExport($selectedStudents), 'selected_students.xlsx');
    }




    public function exportSelectedStudentsCsv(Request $request)
    {
        // Validate selected student IDs
        $request->validate([
            'selected_students' => 'required|array'
        ]);

        $selectedStudents = Student::whereIn('id', $request->input('selected_students'))->get();

        if ($selectedStudents->isEmpty()) {
            return abort(404, 'No students were selected for export.');
        }

        return Excel::download(new SelectedStudentsExport($selectedStudents), 'selected_students.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportSelectedStudentsPdf(Request $request)
    {
        // Validate selected student IDs
        $request->validate([
            'selected_students' => 'required|array'
        ]);

        $selectedStudents = Student::whereIn('id', $request->input('selected_students'))->get();

        if ($selectedStudents->isEmpty()) {
            return abort(404, 'No students were selected for export.');
        }

        // Generate PDF content
        $pdfContent = view('pdf.selected_students', compact('selectedStudents'));

        // Generate PDF file
        $dompdf = new Dompdf();
        $dompdf->loadHtml($pdfContent);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Download PDF file
        return $dompdf->stream('selected_students.pdf');
    }
}
