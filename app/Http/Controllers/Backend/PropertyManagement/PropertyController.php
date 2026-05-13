<?php

namespace App\Http\Controllers\Backend\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->paginate(15);
        return view('backend.property-management.properties.index', compact('properties'));
    }

    // Redirect create to index (modal handles it)
    public function create()
    {
        return redirect()->route('properties-management.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address'        => 'required|string|max:500',
            'client_email'   => 'nullable|email',
            'landlord_email' => 'nullable|email',
        ]);

        Property::create($request->all());

        return redirect()->route('properties-management.index')
            ->with('success', 'Property created successfully.');
    }

    public function show(Property $propertiesManagement)
    {
        $propertiesManagement->load(['managedJobs', 'teamLogs', 'dailyFinances']);
        return view('backend.property-management.properties.show', ['property' => $propertiesManagement]);
    }

    // Redirect edit to index (modal handles it)
    public function edit(Property $propertiesManagement)
    {
        return redirect()->route('properties-management.index');
    }

    public function update(Request $request, Property $propertiesManagement)
    {
        $request->validate([
            'address'        => 'required|string|max:500',
            'client_email'   => 'nullable|email',
            'landlord_email' => 'nullable|email',
        ]);

        $propertiesManagement->update($request->all());

        return redirect()->route('properties-management.index')
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $propertiesManagement)
    {
        $propertiesManagement->delete();
        return redirect()->route('properties-management.index')
            ->with('success', 'Property deleted successfully.');
    }
}
