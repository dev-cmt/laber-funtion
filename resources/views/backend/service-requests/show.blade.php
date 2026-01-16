<x-backend-layout title="Service Request Details">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Service Request Details</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('service-requests.index') }}">Service Requests</a></li>
                    <li class="breadcrumb-item active" aria-current="page">SR-{{ str_pad($serviceRequest->id, 6, '0', STR_PAD_LEFT) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            {{-- Customer Information --}}
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Customer Information</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $serviceRequest->customer_name }}</p>
                            <p><strong>Phone:</strong> {{ $serviceRequest->customer_phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Address:</strong> {{ $serviceRequest->customer_address }}</p>
                            <p><strong>Requested On:</strong> {{ $serviceRequest->created_at->format('d M, Y H:i') }}</p>
                        </div>
                        @if($serviceRequest->customer_notes)
                        <div class="col-12">
                            <p><strong>Customer Notes:</strong></p>
                            <div class="border rounded p-3 bg-light">
                                {{ $serviceRequest->customer_notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Inspection Assignment --}}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Inspection Assignment</div>
                    @if($serviceRequest->status == 'requested')
                        <a href="{{ route('service-requests.assign-inspection', $serviceRequest) }}" 
                           class="btn btn-primary btn-sm">
                            Assign Inspection
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if($serviceRequest->assignedEmployee)
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Assigned To:</strong> {{ $serviceRequest->assignedEmployee->name }}</p>
                                <p><strong>Phone:</strong> {{ $serviceRequest->assignedEmployee->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Visit Date:</strong> {{ date('d M, Y', strtotime($serviceRequest->visit_date)) }}</p>
                                <p><strong>Priority:</strong> 
                                    @php
                                        $priorityBadge = [
                                            'low' => 'info',
                                            'medium' => 'warning',
                                            'high' => 'danger',
                                            'urgent' => 'dark'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $priorityBadge[$serviceRequest->priority] ?? 'warning' }}-transparent">
                                        {{ ucfirst($serviceRequest->priority) }}
                                    </span>
                                </p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-{{ $serviceRequest->status == 'assigned' ? 'info' : 'success' }}-transparent">
                                        {{ ucfirst($serviceRequest->status) }}
                                    </span>
                                </p>
                            </div>
                            
                            @if($serviceRequest->visit_time)
                            <div class="col-md-6 mt-3">
                                <p><strong>Visit Time:</strong> {{ $serviceRequest->visit_time }}</p>
                            </div>
                            @endif
                            
                            @if($serviceRequest->estimated_hours)
                            <div class="col-md-6 mt-3">
                                <p><strong>Estimated Hours:</strong> {{ $serviceRequest->estimated_hours }} hours</p>
                            </div>
                            @endif
                            
                            @if($serviceRequest->required_tools && is_array($serviceRequest->required_tools) && count($serviceRequest->required_tools) > 0)
                            <div class="col-12 mt-3">
                                <p><strong>Required Tools:</strong></p>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($serviceRequest->required_tools as $tool)
                                        <span class="badge bg-light text-dark border">{{ ucfirst(str_replace('_', ' ', $tool)) }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            @if($serviceRequest->assignment_notes)
                            <div class="col-12 mt-3">
                                <p><strong>Assignment Notes:</strong></p>
                                <div class="border rounded p-3 bg-light">
                                    {{ $serviceRequest->assignment_notes }}
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <p class="text-muted">No inspection assigned yet.</p>
                    @endif
                </div>
            </div>

            {{-- Inspection Report --}}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Inspection Report</div>
                    @if(in_array($serviceRequest->status, ['assigned', 'inspected']))
                        <a href="{{ route('service-requests.inspection-report', $serviceRequest) }}" 
                           class="btn btn-primary btn-sm">
                            @if($serviceRequest->status == 'assigned')
                                Add Report
                            @else
                                Edit Report
                            @endif
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if($serviceRequest->technician_notes || $serviceRequest->products->count() > 0)
                        @if($serviceRequest->technician_notes)
                        <p><strong>Technician Notes:</strong></p>
                        <div class="border rounded p-3 bg-light mb-4">
                            {{ $serviceRequest->technician_notes }}
                        </div>
                        @endif

                        @if($serviceRequest->products->count() > 0)
                        <p><strong>Required Products:</strong></p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($serviceRequest->products as $product)
                                    <tr>
                                        <td>{{ $product->product->name }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->notes ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    @else
                        <p class="text-muted">No inspection report submitted yet.</p>
                    @endif
                </div>
            </div>

            {{-- Admin Approval --}}
            @if($serviceRequest->status == 'inspected')
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Admin Approval</div>
                    <a href="{{ route('service-requests.approval', $serviceRequest) }}" 
                       class="btn btn-primary btn-sm">
                        Process Approval
                    </a>
                </div>
                <div class="card-body">
                    <p class="text-muted">Waiting for admin approval...</p>
                </div>
            </div>
            @endif

            @if($serviceRequest->status == 'approved' || $serviceRequest->status == 'rejected')
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Approval Details</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $serviceRequest->status == 'approved' ? 'success' : 'danger' }}-transparent">
                                    {{ ucfirst($serviceRequest->status) }}
                                </span>
                            </p>
                            <p><strong>Approved By:</strong> {{ $serviceRequest->approvedBy->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Approved At:</strong> {{ $serviceRequest->approved_at ? date('d M, Y H:i', strtotime($serviceRequest->approved_at)) : 'N/A' }}</p>
                        </div>
                        @if($serviceRequest->admin_notes)
                        <div class="col-12">
                            <p><strong>Admin Notes:</strong></p>
                            <div class="border rounded p-3 bg-light">
                                {{ $serviceRequest->admin_notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>

        <div class="col-xl-4">
            {{-- Status Timeline --}}
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Status Timeline</div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="timeline-steps">
                        @php
                            $statuses = ['requested', 'assigned', 'inspected', 'approved', 'completed'];
                            $currentIndex = array_search($serviceRequest->status, $statuses);
                            if ($currentIndex === false) {
                                $currentIndex = -1;
                            }
                        @endphp
                        
                        @foreach($statuses as $index => $status)
                            @php
                                $isCompleted = $index < $currentIndex;
                                $isActive = $index === $currentIndex;
                                $isPending = $index > $currentIndex;
                            @endphp

                            <div class="d-flex position-relative @if(!$loop->last) pb-4 @endif">
                                {{-- Vertical Line Connector --}}
                                @if(!$loop->last)
                                    <div class="position-absolute border-start border-2 h-100" 
                                        style="left: 12px; top: 20px; z-index: 0; border-color: {{ $index < $currentIndex ? '#8657dc' : '#e9ecef' }} !important;">
                                    </div>
                                @endif

                                {{-- Icon/Circle --}}
                                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                    style="width: 25px; height: 25px; z-index: 1; background-color: {{ $isCompleted || $isActive ? '#8657dc' : '#f8f9fa' }}; color: {{ $isCompleted || $isActive ? '#fff' : '#adb5bd' }};">
                                    @if($isCompleted)
                                        <i class="ri-check-line fs-14"></i>
                                    @else
                                        <small class="fw-bold">{{ $index + 1 }}</small>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="ms-3">
                                    <h6 class="mb-0 fw-semibold {{ $isActive ? 'text-primary' : ($isPending ? 'text-muted' : '') }}">
                                        {{ ucfirst($status) }}
                                    </h6>
                                    
                                    <div class="text-muted small">
                                        @if($status === 'requested')
                                            <span>{{ $serviceRequest->created_at->format('d M, Y • H:i') }}</span>
                                        @elseif($status === 'assigned' && $serviceRequest->visit_date)
                                            <span>Scheduled for {{ date('d M, Y', strtotime($serviceRequest->visit_date)) }}</span>
                                        @elseif($status === 'inspected' && $serviceRequest->technician_notes)
                                            <span>Report documented</span>
                                        @elseif($status === 'approved' && $serviceRequest->approved_at)
                                            <span>Approved on {{ date('d M, Y', strtotime($serviceRequest->approved_at)) }}</span>
                                        @elseif($isActive)
                                            <span class="badge bg-soft-primary text-primary mt-1">In Progress</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Quick Actions</div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($serviceRequest->status == 'requested')
                            <a href="{{ route('service-requests.assign-inspection', $serviceRequest) }}" 
                               class="btn btn-primary">
                                <i class="ri-user-add-line me-1"></i>Assign Inspection
                            </a>
                            
                            <a href="{{ route('service-requests.edit', $serviceRequest) }}" 
                               class="btn btn-warning">
                                <i class="ri-pencil-line me-1"></i>Edit Request
                            </a>
                        @endif

                        @if(in_array($serviceRequest->status, ['assigned', 'inspected']))
                            <a href="{{ route('service-requests.inspection-report', $serviceRequest) }}" 
                               class="btn btn-info">
                                <i class="ri-file-text-line me-1"></i>
                                {{ $serviceRequest->status == 'assigned' ? 'Add Inspection Report' : 'Edit Report' }}
                            </a>
                        @endif

                        @if($serviceRequest->status == 'inspected')
                            <a href="{{ route('service-requests.approval', $serviceRequest) }}" 
                               class="btn btn-success">
                                <i class="ri-check-double-line me-1"></i>Process Approval
                            </a>
                        @endif

                        @if($serviceRequest->status == 'approved')
                            <form action="{{ route('service-requests.update-status', $serviceRequest) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-dark w-100" onclick="return confirm('Mark as completed?')">
                                    <i class="ri-checkbox-circle-line me-1"></i>Mark as Completed
                                </button>
                            </form>
                        @endif

                        @if(in_array($serviceRequest->status, ['requested', 'assigned', 'inspected']))
                            <form action="{{ route('service-requests.update-status', $serviceRequest) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to cancel this request?')">
                                    <i class="ri-close-circle-line me-1"></i>Cancel Request
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('service-requests.index') }}" class="btn btn-light">
                            <i class="ri-arrow-left-line me-1"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>

            {{-- Request Information --}}
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Request Information</div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Request ID:</strong> 
                            <span class="text-muted">SR-{{ str_pad($serviceRequest->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Created By:</strong> 
                            <span class="text-muted">{{ $serviceRequest->createdBy->name ?? 'N/A' }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Last Updated:</strong> 
                            <span class="text-muted">{{ $serviceRequest->updated_at->format('d M, Y H:i') }}</span>
                        </li>
                        @if($serviceRequest->required_tools && is_array($serviceRequest->required_tools) && count($serviceRequest->required_tools) > 0)
                        <li class="mb-2">
                            <strong>Tools Required:</strong> 
                            <div class="mt-1">
                                @foreach($serviceRequest->required_tools as $tool)
                                    <span class="badge bg-light text-dark border fs-11 me-1 mb-1">{{ ucfirst(str_replace('_', ' ', $tool)) }}</span>
                                @endforeach
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    <style>
        .timeline {
            position: relative;
        }
        .timeline-item {
            position: relative;
        }
        .timeline-line {
            position: absolute;
            width: 2px;
            background-color: #e9ecef;
            left: 9px;
            top: 24px;
            bottom: -24px;
        }
        .timeline-item:last-child .timeline-line {
            display: none;
        }
        .timeline-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            z-index: 1;
        }
        .timeline-icon.bg-light {
            color: #6c757d;
        }
        .timeline-steps .border-start {
            border-color: #e9ecef !important;
        }
        .timeline-steps .border-start.bg-primary {
            border-color: #8657dc !important;
        }
    </style>
    @endpush

    @push('js')
    <script>
        $(document).ready(function() {
            // Handle status update forms
            $('form[action*="update-status"]').submit(function(e) {
                const status = $(this).find('input[name="status"]').val();
                let message = '';
                
                if (status === 'completed') {
                    message = 'Are you sure you want to mark this request as completed?';
                } else if (status === 'cancelled') {
                    message = 'Are you sure you want to cancel this request? This action cannot be undone.';
                }
                
                if (message && !confirm(message)) {
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
            
            // Add loading state to buttons
            $('form').submit(function() {
                const submitBtn = $(this).find('button[type="submit"]');
                if (submitBtn.length) {
                    submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line ri-spin me-1"></i> Processing...');
                }
            });
        });
    </script>
    @endpush
</x-backend-layout>