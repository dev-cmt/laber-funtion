<?php

namespace App\Http\Controllers\Backend\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\ManagedJob;
use App\Models\TeamLog;
use App\Models\DailyFinance;
use App\Models\TodoList;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->paginate(10);
        $managedJobs = ManagedJob::with('property')->latest()->paginate(10);
        $teamLogs = TeamLog::with('property')->latest()->paginate(10);
        $dailyFinances = DailyFinance::with('property')->latest()->paginate(10);
        $todoLists = TodoList::latest()->paginate(10);

        $stats = [
            'total_properties' => Property::count(),
            'total_jobs' => ManagedJob::count(),
            'total_logs' => TeamLog::count(),
            'total_finances' => DailyFinance::count(),
            'total_todos' => TodoList::count(),
            'pending_jobs' => ManagedJob::where('status', 'pending')->count(),
            'unpaid_logs' => TeamLog::where('is_paid', false)->count(),
        ];

        // Get all properties for select dropdowns
        $allProperties = Property::all();

        return view('backend.property-management.dashboard', compact(
            'properties',
            'managedJobs',
            'teamLogs',
            'dailyFinances',
            'todoLists',
            'stats',
            'allProperties'
        ));
    }

    // Update Property
    public function updateProperty(Request $request, Property $property)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:500',
            'client_name' => 'nullable|string',
            'client_email' => 'nullable|email',
            'tenant_name' => 'nullable|string',
            'landlord_name' => 'nullable|string',
            'landlord_email' => 'nullable|email',
        ]);

        $property->update($validated);

        return redirect()->back()->with('success', 'Property updated successfully.');
    }

    // Update Managed Job
    public function updateJob(Request $request, ManagedJob $job)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'scheduled_at' => 'nullable|datetime',
            'job_details' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
            'agreed_price' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
        ]);

        $validated['total_price'] = ($validated['agreed_price'] ?? 0) + ($validated['vat'] ?? 0);
        $job->update($validated);

        return redirect()->back()->with('success', 'Job updated successfully.');
    }

    // Update Team Log
    public function updateLog(Request $request, TeamLog $log)
    {
        $validated = $request->validate([
            'member_name' => 'required|string',
            'date' => 'required|date',
            'site_id' => 'nullable|exists:properties,id',
            'shift_type' => 'required|in:Half,Full',
            'daily_pay' => 'nullable|numeric|min:0',
            'is_paid' => 'required|boolean',
        ]);

        $log->update($validated);

        return redirect()->back()->with('success', 'Team log updated successfully.');
    }

    // Update Daily Finance
    public function updateFinance(Request $request, DailyFinance $finance)
    {
        $validated = $request->validate([
            'expense_type' => 'required|string',
            'site_id' => 'nullable|exists:properties,id',
            'date' => 'required|date',
            'cash_out' => 'nullable|numeric|min:0',
            'cash_in' => 'nullable|numeric|min:0',
            'acc_out' => 'nullable|numeric|min:0',
            'acc_in' => 'nullable|numeric|min:0',
        ]);

        $finance->update($validated);

        return redirect()->back()->with('success', 'Daily finance updated successfully.');
    }

    // Update Todo
    public function updateTodo(Request $request, TodoList $todo)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in-progress,completed',
            'due_date' => 'nullable|date',
            'type' => 'required|in:Appointment,To-Do',
        ]);

        $todo->update($validated);

        return redirect()->back()->with('success', 'To-do updated successfully.');
    }

    // API Endpoints for Fetching Data
    public function getPropertyData(Property $property)
    {
        return response()->json($property);
    }

    public function getJobData(ManagedJob $job)
    {
        return response()->json($job);
    }

    public function getLogData(TeamLog $log)
    {
        return response()->json($log);
    }

    public function getFinanceData(DailyFinance $finance)
    {
        return response()->json($finance);
    }

    public function getTodoData(TodoList $todo)
    {
        return response()->json($todo);
    }
