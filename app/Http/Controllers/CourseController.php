<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Course::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'instructor' => 'required|max:255',
            'schedule' => 'required|max:255',
            'department' => 'required|max:255',
            'fee' => 'required|numeric|min:0',
            'prerequisites' => 'required',

        ]);

        // Create a new course record in the database
        $course = Course::create($validatedData);

        // Redirect to a success page or back to the form with a success message
        return redirect()->route('courses.create')->with('success', 'Course created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Course::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->all());
        return response()->json($course, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Course::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
