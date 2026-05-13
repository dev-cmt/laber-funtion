<?php

namespace App\Http\Controllers\Backend\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\DailyFinance;
use App\Models\Property;
use Illuminate\Http\Request;

class DailyFinanceController extends Controller
{
    public function index()
    {
        $finances = DailyFinance::with('property')->latest()->paginate(15);
        $properties = Property::orderBy('address')->get();
        return view('backend.property-management.daily-finances.index', compact('finances', 'properties'));
    }

    public function create()
    {
        return redirect()->route('daily-finances.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_type' => 'required|string|max:255',
            'date'         => 'required|date',
            'site_id'      => 'nullable|exists:properties,id',
        ]);

        DailyFinance::create($request->all());

        return redirect()->route('daily-finances.index')
            ->with('success', 'Finance record created successfully.');
    }

    public function edit(DailyFinance $dailyFinance)
    {
        return redirect()->route('daily-finances.index');
    }

    public function update(Request $request, DailyFinance $dailyFinance)
    {
        $request->validate([
            'expense_type' => 'required|string|max:255',
            'date'         => 'required|date',
            'site_id'      => 'nullable|exists:properties,id',
        ]);

        $dailyFinance->update($request->all());

        return redirect()->route('daily-finances.index')
            ->with('success', 'Finance record updated successfully.');
    }

    public function destroy(DailyFinance $dailyFinance)
    {
        $dailyFinance->delete();
        return redirect()->route('daily-finances.index')
            ->with('success', 'Finance record deleted successfully.');
    }
}
