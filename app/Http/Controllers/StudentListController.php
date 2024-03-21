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
        return view('students.studentlist', compact('students', 'departments'));
    }

    // Add this method for showing the edit form
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $departments = Department::all(); // Fetch all departments
        return view('students.edit', compact('student', 'departments'));
    }

    // Add this method for updating a student
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:students,name,' . $id,
            'email' => 'required|unique:students,email,' . $id,
            'rollnumber' => 'required|unique:students,rollnumber,' . $id,
            'mobile_number' => 'required|unique:students,mobile_number,' . $id,
            'department_name' => 'required', // Validate department name
            'department_id' => 'required|exists:departments,id', // Validate department ID
        ]);

        $student = Student::findOrFail($id);

        // Update the student details
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'rollnumber' => $request->rollnumber,
            'mobile_number' => $request->mobile_number,
            'department_id' => $request->department_id, // Update department ID
        ]);

        // Optionally, update the department name if it has changed
        $department = Department::findOrFail($request->department_id);
        if ($department->department_name !== $request->department_name) {
            $department->update(['department_name' => $request->department_name]);
        }

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
