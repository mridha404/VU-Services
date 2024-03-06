<?php

// app/Http/Controllers/PrintController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PrintController extends Controller
{
    public function showForm()
    {
        return view('print.form');
    }

    // Add more methods for handling form submissions, calculations, etc., as needed
}

