<?php

// app/Http/Controllers/ServicesController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'servicename' => 'required|unique:services,servicename',
            'servicedescription' => 'required|unique:services,servicedescription',
            'price' => 'required|numeric',
        ]);

        Service::create($request->all());

        return redirect()->route('services.list')->with('success', 'Service added successfully!');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'servicename' => 'required|unique:services,servicename,'.$service->id,  //only for update it will check only this id not all .use for update only.
            'servicedescription' => 'required|unique:services,servicedescription,'.$service->id,  //only for update it will check only this id not all .use for update only.
            'price' => 'required|numeric',
        ]);

        $service->update($request->all());

        return redirect()->route('services.list')->with('success', 'Service updated successfully!');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.list')->with('success', 'Service deleted successfully!');
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('services.show', compact('service'));
    }
}
