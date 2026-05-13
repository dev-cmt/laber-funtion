<?php

namespace App\Http\Controllers\Backend\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\TeamLog;
use App\Models\Property;
use Illuminate\Http\Request;

class TeamLogController extends Controller
{
    public function index()
    {
        $logs = TeamLog::with('property')->latest()->paginate(15);
        $properties = Property::orderBy('address')->get();
        return view('backend.property-management.team-logs.index', compact('logs', 'properties'));
    }

    public function create()
    {
        return redirect()->route('team-logs.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'date'        => 'required|date',
            'site_id'     => 'required|exists:properties,id',
            'shift_type'  => 'required|in:Full,Half',
            'daily_pay'   => 'required|numeric|min:0',
        ]);

        $data = $request->except('receipt_links_upload');
        $data['is_paid'] = $request->has('is_paid') ? 1 : 0;

        TeamLog::create($data);

        return redirect()->route('team-logs.index')
            ->with('success', 'Team log created successfully.');
    }

    public function edit(TeamLog $teamLog)
    {
        return redirect()->route('team-logs.index');
    }

    public function update(Request $request, TeamLog $teamLog)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'date'        => 'required|date',
            'site_id'     => 'required|exists:properties,id',
            'shift_type'  => 'required|in:Full,Half',
            'daily_pay'   => 'required|numeric|min:0',
        ]);

        $data = $request->except('receipt_links_upload');
        $data['is_paid'] = $request->has('is_paid') ? 1 : 0;

        $teamLog->update($data);

        return redirect()->route('team-logs.index')
            ->with('success', 'Team log updated successfully.');
    }

    public function destroy(TeamLog $teamLog)
    {
        $teamLog->delete();
        return redirect()->route('team-logs.index')
            ->with('success', 'Team log deleted successfully.');
    }
}
