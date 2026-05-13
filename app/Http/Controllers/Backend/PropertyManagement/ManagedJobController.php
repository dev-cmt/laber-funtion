<?php

namespace App\Http\Controllers\Backend\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\ManagedJob;
use App\Models\Property;
use Illuminate\Http\Request;

class ManagedJobController extends Controller
{
    public function index()
    {
        $jobs = ManagedJob::with('property')->latest()->paginate(15);
        $properties = Property::orderBy('address')->get();
        return view('backend.property-management.jobs.index', compact('jobs', 'properties'));
    }

    public function create()
    {
        return redirect()->route('managed-jobs.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'status'      => 'required|in:Pending,In Progress,Completed,Cancelled',
        ]);

        $data = $request->all();
        if (!$request->filled('total_price')) {
            $data['total_price'] = ($request->agreed_price ?? 0) + ($request->vat ?? 0);
        }

        ManagedJob::create($data);

        return redirect()->route('managed-jobs.index')
            ->with('success', 'Job created successfully.');
    }

    public function show(ManagedJob $managedJob)
    {
        $managedJob->load('property');
        return view('backend.property-management.jobs.show', compact('managedJob'));
    }

    public function edit(ManagedJob $managedJob)
    {
        return redirect()->route('managed-jobs.index');
    }

    public function update(Request $request, ManagedJob $managedJob)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'status'      => 'required|in:Pending,In Progress,Completed,Cancelled',
        ]);

        $data = $request->all();
        if (!$request->filled('total_price')) {
            $data['total_price'] = ($request->agreed_price ?? 0) + ($request->vat ?? 0);
        }

        $managedJob->update($data);

        return redirect()->route('managed-jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    public function destroy(ManagedJob $managedJob)
    {
        $managedJob->delete();
        return redirect()->route('managed-jobs.index')
            ->with('success', 'Job deleted successfully.');
    }
}
