<?php

// app/Http/Controllers/SearchDeptController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Student;

class SearchDeptController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        $students = [];

        return view('search-department.index', compact('departments', 'students'));
    }

    public function search(Request $request)
    {
        $departments = Department::all();
        $students = [];

        if ($request->has('department_id')) {
            $departmentId = $request->input('department_id');
            $students = Student::whereHas('department', function ($query) use ($departmentId) {
                $query->where('id', $departmentId);
            })->get();
        }

        return view('search-department.index', compact('departments', 'students'));
    }
}
