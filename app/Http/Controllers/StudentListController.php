<?php

// app/Http/Controllers/StudentListController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;

class StudentListController extends Controller
{
    // Existing method for listing students
    public function studentlist()
    {
        $students = Student::all();
        $departments = Department::all();
        return view('students.studentlist', compact('students','departments'));
    }

    // Add this method for showing the edit form
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    // Add this method for updating a student
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:students,name,'.$id,
            'email' => 'required|unique:students,email,'.$id,
            'rollnumber' => 'required|unique:students,rollnumber,'.$id,
            'mobile_number' => 'required|unique:students,mobile_number,'.$id,
            
           
           
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all());

        return redirect()->route('students.studentlist')->with('success', 'Student updated successfully!');
    }

    // Add this method for deleting a student
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.studentlist')->with('success', 'Student deleted successfully!');
    }


    

}
