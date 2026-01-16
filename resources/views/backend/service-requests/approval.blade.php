<x-backend-layout title="Service Request Approval">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Service Request Approval</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('service-requests.index') }}">Service Requests</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('service-requests.show', $serviceRequest) }}">
                            SR-{{ str_pad($serviceRequest->id, 6, '0', STR_PAD_LEFT) }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Approval</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Review and Approve Service Request</div>
                </div>
                <div class="card-body">
                    
                    {{-- Customer Info Card --}}
                    <div class="card bg-light border mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Customer:</strong> {{ $serviceRequest->customer_name }}</p>
                                    <p class="mb-1"><strong>Phone:</strong> {{ $serviceRequest->customer_phone }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Address:</strong> {{ $serviceRequest->customer_address }}</p>
                                    <p class="mb-1"><strong>Request Date:</strong> {{ $serviceRequest->created_at->format('d M, Y') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Assigned To:</strong> {{ $serviceRequest->assignedEmployee->name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Visit Date:</strong> {{ $serviceRequest->visit_date ? date('d M, Y', strtotime($serviceRequest->visit_date)) : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Success/Error Alerts --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Inspection Report Summary --}}
                    <div class="card border mb-4">
                        <div class="card-header bg-light">
                            <div class="card-title">Inspection Report Summary</div>
                        </div>
                        <div class="card-body">
                            @if($serviceRequest->technician_notes)
                                <h6 class="mb-2">Technician Notes:</h6>
                                <div class="border rounded p-3 mb-4 bg-light">
                                    {{ $serviceRequest->technician_notes }}
                                </div>
                            @endif

                            @if($serviceRequest->products->count() > 0)
                                <h6 class="mb-2">Required Products:</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Code</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalCost = 0;
                                            @endphp
                                            @foreach($serviceRequest->products as $key => $productItem)
                                                @php
                                                    $product = $productItem->product;
                                                    $quantity = $productItem->quantity;
                                                    $unitPrice = $product->selling_price ?? $product->purchase_price ?? 0;
                                                    $subtotal = $unitPrice * $quantity;
                                                    $totalCost += $subtotal;
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->code }}</td>
                                                    <td>{{ $quantity }}</td>
                                                    <td>৳{{ number_format($unitPrice, 2) }}</td>
                                                    <td>৳{{ number_format($subtotal, 2) }}</td>
                                                    <td>{{ $productItem->notes ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-end"><strong>Total Estimated Cost:</strong></td>
                                                <td colspan="2"><strong>৳{{ number_format($totalCost, 2) }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No products listed in the inspection report.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Approval Form --}}
                    <div class="card border">
                        <div class="card-header bg-light">
                            <div class="card-title">Approval Decision</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('service-requests.approval.process', $serviceRequest) }}" method="POST" id="approvalForm">
                                @csrf
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Decision <span class="text-danger">*</span></label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="action" id="approve" value="approve" required>
                                                    <label class="form-check-label text-success fw-semibold" for="approve">
                                                        <i class="ri-checkbox-circle-line me-1"></i> Approve
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="action" id="reject" value="reject" required>
                                                    <label class="form-check-label text-danger fw-semibold" for="reject">
                                                        <i class="ri-close-circle-line me-1"></i> Reject
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Final Service Cost</label>
                                            <div class="input-group">
                                                <span class="input-group-text">৳</span>
                                                <input type="number" 
                                                       class="form-control" 
                                                       name="final_cost" 
                                                       id="finalCost"
                                                       value="{{ old('final_cost', $totalCost) }}"
                                                       min="0"
                                                       step="0.01">
                                            </div>
                                            <small class="text-muted">Adjust if different from estimated cost</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Admin Notes</label>
                                    <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                              name="admin_notes" 
                                              rows="4"
                                              placeholder="Add approval notes, instructions, or reasons for rejection...">{{ old('admin_notes') }}</textarea>
                                    @error('admin_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">These notes will be visible to the technician and customer</small>
                                </div>

                                {{-- Additional Fields for Approval --}}
                                <div class="row" id="approvalFields">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Service Start Date</label>
                                            <input type="date" 
                                                   class="form-control" 
                                                   name="service_start_date"
                                                   id="serviceStartDate"
                                                   value="{{ old('service_start_date') }}"
                                                   min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Service Completion Date</label>
                                            <input type="date" 
                                                   class="form-control" 
                                                   name="service_completion_date"
                                                   id="serviceCompletionDate"
                                                   value="{{ old('service_completion_date') }}"
                                                   min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Warranty Period (Months)</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="warranty_period"
                                                   value="{{ old('warranty_period', 3) }}"
                                                   min="0"
                                                   max="60">
                                        </div>
                                    </div>
                                </div>

                                {{-- Rejection Reason (only show when reject is selected) --}}
                                <div class="mb-4 d-none" id="rejectionReason">
                                    <label class="form-label text-danger">Reason for Rejection <span class="text-danger">*</span></label>
                                    <textarea class="form-control" 
                                              name="rejection_reason" 
                                              rows="3"
                                              placeholder="Please provide detailed reason for rejection...">{{ old('rejection_reason') }}</textarea>
                                    <small class="text-muted">This will be communicated to the customer</small>
                                </div>

                                {{-- Buttons --}}
                                <div class="d-flex justify-content-between mt-4">
                                    <div>
                                        <a href="{{ route('service-requests.show', $serviceRequest) }}" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i> Back to Request
                                        </a>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <i class="ri-check-double-line me-1"></i> Submit Decision
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Audit Trail --}}
                    <div class="card border mt-4">
                        <div class="card-header bg-light">
                            <div class="card-title">Request History</div>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-time">{{ $serviceRequest->created_at->format('d M, Y H:i') }}</div>
                                    <div class="timeline-icon bg-primary">
                                        <i class="ri-add-line"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Request Created</h6>
                                        <p class="text-muted">By: {{ $serviceRequest->createdBy->name ?? 'System' }}</p>
                                    </div>
                                </div>
                                
                                @if($serviceRequest->assigned_to)
                                <div class="timeline-item">
                                    <div class="timeline-time">{{ $serviceRequest->updated_at->format('d M, Y H:i') }}</div>
                                    <div class="timeline-icon bg-info">
                                        <i class="ri-user-add-line"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Inspection Assigned</h6>
                                        <p class="text-muted">To: {{ $serviceRequest->assignedEmployee->name ?? 'N/A' }}</p>
                                        <p class="text-muted">Visit Date: {{ $serviceRequest->visit_date ? date('d M, Y', strtotime($serviceRequest->visit_date)) : 'N/A' }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                @if($serviceRequest->technician_notes)
                                <div class="timeline-item">
                                    <div class="timeline-time">{{ $serviceRequest->updated_at->format('d M, Y H:i') }}</div>
                                    <div class="timeline-icon bg-warning">
                                        <i class="ri-file-text-line"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Inspection Report Submitted</h6>
                                        <p class="text-muted">By: {{ $serviceRequest->assignedEmployee->name ?? 'Technician' }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    <style>
        .timeline {
            position: relative;
            padding-left: 40px;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        .timeline-time {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .timeline-icon {
            position: absolute;
            left: -40px;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .timeline-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 3px solid #dee2e6;
        }
        .timeline-content h6 {
            margin-bottom: 5px;
            color: #495057;
        }
        .form-check-input:checked {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
    </style>
    @endpush

    @push('js')
    <script>
        $(document).ready(function() {
            // Set minimum dates
            const today = new Date().toISOString().split('T')[0];
            $('#serviceStartDate').attr('min', today);
            $('#serviceCompletionDate').attr('min', today);
            
            // Auto-set service start date to tomorrow
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowStr = tomorrow.toISOString().split('T')[0];
            $('#serviceStartDate').val(tomorrowStr);
            
            // Auto-set completion date to 2 days after start
            const completionDate = new Date(tomorrow);
            completionDate.setDate(completionDate.getDate() + 2);
            const completionStr = completionDate.toISOString().split('T')[0];
            $('#serviceCompletionDate').val(completionStr);
            
            // Show/hide fields based on approval/rejection selection
            $('input[name="action"]').change(function() {
                const selectedValue = $(this).val();
                
                if (selectedValue === 'approve') {
                    $('#approvalFields').show();
                    $('#rejectionReason').addClass('d-none');
                    $('#rejectionReason textarea').prop('required', false);
                    $('#submitBtn')
                        .removeClass('btn-danger')
                        .addClass('btn-primary')
                        .html('<i class="ri-check-double-line me-1"></i> Approve Request');
                } else if (selectedValue === 'reject') {
                    $('#approvalFields').hide();
                    $('#rejectionReason').removeClass('d-none');
                    $('#rejectionReason textarea').prop('required', true);
                    $('#submitBtn')
                        .removeClass('btn-primary')
                        .addClass('btn-danger')
                        .html('<i class="ri-close-circle-line me-1"></i> Reject Request');
                }
            });
            
            // Form validation
            $('#approvalForm').submit(function(e) {
                const action = $('input[name="action"]:checked').val();
                const adminNotes = $('textarea[name="admin_notes"]').val().trim();
                
                if (!action) {
                    e.preventDefault();
                    alert('Please select either Approve or Reject.');
                    return false;
                }
                
                if (action === 'reject') {
                    const rejectionReason = $('textarea[name="rejection_reason"]').val().trim();
                    if (!rejectionReason) {
                        e.preventDefault();
                        alert('Please provide a reason for rejection.');
                        $('#rejectionReason textarea').focus();
                        return false;
                    }
                }
                
                // Confirm action
                const actionText = action === 'approve' ? 'approve' : 'reject';
                if (!confirm(`Are you sure you want to ${actionText} this service request? This action cannot be undone.`)) {
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
            
            // Auto-calculate completion date based on start date
            $('#serviceStartDate').change(function() {
                const startDate = new Date($(this).val());
                if (startDate) {
                    const completionDate = new Date(startDate);
                    completionDate.setDate(completionDate.getDate() + 2);
                    const completionStr = completionDate.toISOString().split('T')[0];
                    $('#serviceCompletionDate').val(completionStr);
                    $('#serviceCompletionDate').attr('min', $(this).val());
                }
            });
            
            // Validate completion date is after start date
            $('#serviceCompletionDate').change(function() {
                const startDate = new Date($('#serviceStartDate').val());
                const completionDate = new Date($(this).val());
                
                if (completionDate < startDate) {
                    alert('Completion date must be after start date.');
                    $(this).val('');
                }
            });
        });
    </script>
    @endpush
</x-backend-layout>