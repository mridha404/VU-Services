<?php

// app/Http/Controllers/StudentPageController.php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Department; 

use Illuminate\Http\Request;

class StudentPageController extends Controller
{
    public function create()

    {
        $departments = Department::all();
        return view('students.create', compact('departments'));
    }

    public function store(Request $request)
    {
        // Validation logic
        $validatedData = $request->validate([
            'name' => 'required|unique:students,name',
            'email' => 'required|email|unique:students,email',
            'rollnumber' => 'required|unique:students,rollnumber',
            'mobile_number' => 'required|unique:students,mobile_number',
            'department_id' => 'required',
        ]);
    
        // Create a new student instance
        $student = new Student();
    
        // Set the user_id to the currently logged-in user
        $student->user_id = auth()->user()->id;
    
        // Set other attributes
        $student->name = $validatedData['name'];
        $student->email = $validatedData['email'];
        $student->rollnumber = $validatedData['rollnumber'];
        $student->mobile_number = $validatedData['mobile_number'];
        $student->department_id = $validatedData['department_id'];
    
        // Save the student
        $student->save();
    
        // Redirect with success message
        return redirect()->route('students.create')->with('success', 'Student information saved successfully!');
    }
}
