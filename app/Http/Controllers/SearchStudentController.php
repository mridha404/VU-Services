<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Support\Facades\DB;


class SearchStudentController extends Controller
{
    // public function search(Request $request)
    // {
    //     $search = $request->input('search');
    //     $students = [];

    //     if ($search) {
    //         $students = Student::where('name', 'like', "%$search%")
    //             ->orWhere('email', 'like', "%$search%")
    //             ->orWhere('rollnumber', 'like', "%$search%")
    //             ->orWhere('mobile_number', 'like', "%$search%")
    //             ->paginate(10);
    //     }

    //   else {

    //   }


    //     $response = view('students.search', compact('students', 'search'))->with('success', session('success'));

    //     // Clear the session data for 'success'
    //     $request->session()->forget('success');

    //     return $response;
    // }


    public function search(Request $request)
    {
        $departments = Department::all();
        $selectedDepartment = $request->input('department');
        $name = $request->input('name');
        $rollnumber = $request->input('rollnumber');
        $mobile_number = $request->input('mobile_number');


        $students = Student::query();

        if ($selectedDepartment) {
            $students->where('department_id', $selectedDepartment);
        }

        if ($name) {
            $students->where('name', 'like', "%$name%");
        }

        if ($rollnumber) {
            $students->where('rollnumber', '=', $rollnumber);
        }

        if ($mobile_number) {
            $students->where('mobile_number', '=', $mobile_number);
        }

        $students = $students->paginate(5);

        $departments = Department::all();

        return view('students.search', compact('students', 'selectedDepartment', 'departments', 'name', 'rollnumber', 'mobile_number'));
    }
}
