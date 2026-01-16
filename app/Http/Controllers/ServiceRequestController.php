<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Product;
use App\Models\ServiceRequestProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $requests = ServiceRequest::with(['assignedEmployee', 'products'])
            ->latest()
            ->paginate(20);
        
        return view('backend.service-requests.index', compact('requests'));
    }

    public function create()
    {
        $employees = User::where('status', true)->get();
        $products = Product::active()->get();
        
        return view('backend.service-requests.create', compact('employees', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $serviceRequest = ServiceRequest::create([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'customer_notes' => $validated['customer_notes'],
                'status' => 'requested',
                'requested_by' => Auth::user()->id,
            ]);

            DB::commit();
            
            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('success', 'Service request created successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create service request: ' . $e->getMessage());
        }
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['assignedEmployee', 'products.product', 'createdBy']);
        $employees = User::where('status', true)->get();
        $products = Product::active()->get();
        
        return view('backend.service-requests.show', compact('serviceRequest', 'employees', 'products'));
    }

    public function edit(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'requested') {
            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('error', 'Cannot edit request in current status.');
        }
        
        return view('backend.service-requests.edit', compact('serviceRequest'));
    }

    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'requested') {
            return back()->with('error', 'Cannot edit request in current status.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_notes' => 'nullable|string',
        ]);

        $serviceRequest->update($validated);
        
        return redirect()->route('service-requests.show', $serviceRequest)
            ->with('success', 'Service request updated successfully.');
    }

    public function destroy(ServiceRequest $serviceRequest)
    {
        if (!in_array($serviceRequest->status, ['requested', 'rejected'])) {
            return back()->with('error', 'Cannot delete request in current status.');
        }
        
        $serviceRequest->delete();
        
        return redirect()->route('service-requests.index')
            ->with('success', 'Service request deleted successfully.');
    }

    // ======================================
    // INSPECTION ASSIGNMENT METHODS
    // ======================================
    
    public function assignInspectionForm(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'requested') {
            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('error', 'Request already assigned or processed.');
        }
        
        $employees = User::where('status', true)->get();
        
        return view('backend.service-requests.assign-inspection', compact('serviceRequest', 'employees'));
    }

    public function assignInspection(Request $request, ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'requested') {
            return back()->with('error', 'Request is already assigned or in a different status.');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'notes' => 'nullable|string|max:1000',
            'estimated_hours' => 'nullable|numeric|min:0.5|max:8',
            'required_tools' => 'nullable|array',
            'required_tools.*' => 'string|max:50',
        ]);

        DB::beginTransaction();
        try {
            // Prepare assignment data
            $assignmentData = [
                'assigned_to' => $validated['employee_id'],
                'visit_date' => $validated['visit_date'],
                'priority' => $validated['priority'] ?? 'medium',
                'visit_time' => $validated['visit_time'] ?? null,
                'estimated_hours' => $validated['estimated_hours'] ?? null,
                'required_tools' => $validated['required_tools'] ?? null,
                'status' => 'assigned',
                'assignment_notes' => $validated['notes'] ?? null,
            ];

            // If you want to keep JSON structure in assignment_notes, use this:
            // $extraInfo = [
            //     'visit_time' => $validated['visit_time'] ?? null,
            //     'priority' => $validated['priority'] ?? 'medium',
            //     'estimated_hours' => $validated['estimated_hours'] ?? null,
            //     'required_tools' => $validated['required_tools'] ?? [],
            // ];
            // $assignmentData['assignment_notes'] = json_encode([
            //     'instructions' => $validated['notes'] ?? '',
            //     'extra_info' => $extraInfo
            // ]);

            // Update service request
            $serviceRequest->update($assignmentData);

            DB::commit();
            
            return redirect()->route('service-requests.show', $serviceRequest)->with('success', 'Inspection assigned successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to assign inspection. Please try again.')->withInput();
        }
    }

    // ======================================
    // INSPECTION REPORT METHODS
    // ======================================
    
    /**
     * Show inspection report form
     */
    public function inspectionReportForm(ServiceRequest $serviceRequest)
    {
        if (!in_array($serviceRequest->status, ['assigned', 'inspected'])) {
            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('error', 'Cannot add inspection report in current status.');
        }
        
        $products = Product::active()->get();
        
        return view('backend.service-requests.inspection-report', compact('serviceRequest', 'products'));
    }

    public function saveInspectionReport(Request $request, ServiceRequest $serviceRequest)
    {
        if (!in_array($serviceRequest->status, ['assigned', 'inspected'])) {
            return back()->with('error', 'Cannot add inspection report in current status.');
        }

        $validated = $request->validate([
            'technician_notes' => 'required|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Clear existing products
            ServiceRequestProduct::where('service_request_id', $serviceRequest->id)->delete();
            
            // Add new products
            foreach ($validated['products'] as $productData) {
                ServiceRequestProduct::create([
                    'service_request_id' => $serviceRequest->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'notes' => $productData['notes'] ?? null,
                ]);
            }
            
            // Update service request
            $serviceRequest->update([
                'technician_notes' => $validated['technician_notes'],
                'status' => 'inspected',
            ]);

            DB::commit();
            
            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('success', 'Inspection report saved successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save inspection report: ' . $e->getMessage());
        }
    }

    // ======================================
    // APPROVAL METHODS
    // ======================================
    
    public function approvalForm(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'inspected') {
            return redirect()->route('service-requests.show', $serviceRequest)
                ->with('error', 'Cannot approve/reject in current status.');
        }
        
        $serviceRequest->load('products.product');
        
        return view('backend.service-requests.approval', compact('serviceRequest'));
    }

    public function processApproval(Request $request, ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'inspected') {
            return back()->with('error', 'Cannot approve/reject in current status.');
        }

        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string',
        ]);

        $status = $validated['action'] === 'approve' ? 'approved' : 'rejected';
        
        $serviceRequest->update([
            'status' => $status,
            'admin_notes' => $validated['admin_notes'] ?? null,
            'approved_by' => Auth::user()->id,
            'approved_at' => now(),
        ]);

        return redirect()->route('service-requests.show', $serviceRequest)
            ->with('success', "Service request {$validated['action']}d successfully.");
    }

    // ======================================
    // STATUS UPDATE METHOD
    // ======================================
    
    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:assigned,inspected,approved,completed,cancelled',
        ]);

        $allowedTransitions = [
            'assigned' => ['inspected', 'cancelled'],
            'inspected' => ['approved', 'rejected'],
            'approved' => ['completed', 'cancelled'],
        ];

        if (isset($allowedTransitions[$serviceRequest->status]) && 
            !in_array($validated['status'], $allowedTransitions[$serviceRequest->status])) {
            return back()->with('error', 'Invalid status transition.');
        }

        $serviceRequest->update(['status' => $validated['status']]);
        
        return back()->with('success', 'Status updated successfully.');
    }
}