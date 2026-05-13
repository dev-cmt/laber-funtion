<x-backend-layout title="Job Details">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-bold fs-20 mb-1">Job Specification</h1>
            <p class="text-muted fs-12 mb-0">Full details, requirements and financial summary for the maintenance task.</p>
        </div>
        <div class="ms-md-1 ms-0 mt-md-0 mt-2">
            <div class="btn-list">
                <a href="{{ route('managed-jobs.index') }}" class="btn btn-light border btn-wave">
                    <i class="ri-arrow-left-line me-1"></i> Back to Jobs
                </a>
                <a href="{{ route('managed-jobs.index') }}" class="btn btn-warning btn-wave text-white">
                    <i class="ri-edit-line me-1"></i> Edit Job
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Job Main Details --}}
        <div class="col-xl-8">
            <div class="card custom-card shadow-sm border-0 h-100">
                <div class="card-header bg-primary-transparent py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div class="card-title text-primary fs-15 fw-bold">
                        <i class="ri-briefcase-4-line me-2"></i> Work Information
                    </div>
                    @php
                        $st = match($managedJob->status) {
                            'Completed'  => 'success',
                            'Cancelled'  => 'danger',
                            'In Progress'=> 'warning',
                            default      => 'secondary',
                        };
                    @endphp
                    <span class="badge bg-{{ $st }} rounded-pill px-3">{{ $managedJob->status }}</span>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="text-muted fs-11 fw-bold text-uppercase mb-1 d-block">Property Address</label>
                            <h5 class="fw-bold mb-0">
                                <a href="{{ route('properties-management.show', $managedJob->property_id) }}" class="text-dark hover-primary">
                                    <i class="ri-map-pin-2-fill text-primary me-1"></i>{{ $managedJob->property->address ?? '—' }}
                                </a>
                            </h5>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light border-dashed">
                                <label class="text-muted fs-11 fw-bold text-uppercase mb-1 d-block">Scheduled For</label>
                                <span class="fw-semibold text-dark fs-14">
                                    <i class="ri-calendar-event-line me-1 text-primary"></i>
                                    {{ $managedJob->scheduled_at ? $managedJob->scheduled_at->format('d M Y, H:i') : '—' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light border-dashed">
                                <label class="text-muted fs-11 fw-bold text-uppercase mb-1 d-block">Staff / Attended By</label>
                                <span class="fw-semibold text-dark fs-14">
                                    <i class="ri-user-settings-line me-1 text-primary"></i>
                                    {{ $managedJob->who_attended ?? '—' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="text-muted fs-11 fw-bold text-uppercase mb-1 d-block">Job Description</label>
                            <div class="p-3 rounded-3 bg-white border fs-14 text-dark" style="white-space:pre-wrap; min-height: 100px;">{{ $managedJob->job_details ?? 'No description provided.' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted fs-11 fw-bold text-uppercase mb-1 d-block">Tools Required</label>
                            <div class="p-2 rounded-2 bg-info-transparent border border-info border-opacity-10 text-dark fs-13" style="white-space:pre-wrap">
                                <i class="ri-tools-line me-1"></i>{{ $managedJob->tools_needed ?? 'None listed.' }}
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="text-muted fs-11 fw-bold text-uppercase mb-1 d-block">Materials Needed</label>
                            <div class="p-2 rounded-2 bg-success-transparent border border-success border-opacity-10 text-dark fs-13" style="white-space:pre-wrap">
                                <i class="ri-stack-line me-1"></i>{{ $managedJob->materials_needed ?? 'None listed.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Financial Summary Card --}}
        <div class="col-xl-4">
            <div class="card custom-card shadow-sm border-0 h-100">
                <div class="card-header bg-dark text-white py-3 border-bottom-0 rounded-top">
                    <div class="card-title text-white fs-15 fw-bold">
                        <i class="ri-money-pound-circle-line me-2"></i> Financial Audit
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 bg-light border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted fs-13">Agreed Sub-total</span>
                            <span class="fw-semibold text-dark">${{ number_format($managedJob->agreed_price, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fs-13">VAT Amount</span>
                            <span class="fw-semibold text-dark">${{ number_format($managedJob->vat, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 bg-white rounded shadow-sm">
                            <span class="fw-bold text-dark uppercase fs-12">Grand Total</span>
                            <span class="fw-bold text-primary fs-18">${{ number_format($managedJob->total_price, 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <h6 class="fw-bold fs-12 text-muted uppercase mb-3">Payment Receipts</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs bg-success-transparent text-success me-2 rounded">
                                    <i class="ri-cash-line"></i>
                                </div>
                                <span class="fs-13">Cash Payment</span>
                            </div>
                            <span class="fw-bold text-success">${{ number_format($managedJob->cash_payment_received, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs bg-info-transparent text-info me-2 rounded">
                                    <i class="ri-bank-card-line"></i>
                                </div>
                                <span class="fs-13">Account Transfer</span>
                            </div>
                            <span class="fw-bold text-info">${{ number_format($managedJob->acc_payment_received, 2) }}</span>
                        </div>
                        
                        @php $outstanding = $managedJob->total_price - $managedJob->cash_payment_received - $managedJob->acc_payment_received; @endphp
                        <div class="p-3 rounded-3 {{ $outstanding > 0 ? 'bg-danger-transparent border border-danger border-opacity-10' : 'bg-success-transparent border border-success border-opacity-10' }} text-center">
                            <div class="fs-11 fw-bold uppercase text-muted mb-1">{{ $outstanding > 0 ? 'Outstanding Balance' : 'Payment Status' }}</div>
                            @if($outstanding > 0)
                                <h4 class="fw-bold text-danger mb-0">${{ number_format($outstanding, 2) }}</h4>
                                <small class="text-danger"><i class="ri-error-warning-line me-1"></i>Pending Settlement</small>
                            @else
                                <h4 class="fw-bold text-success mb-0">FULLY PAID</h4>
                                <small class="text-success"><i class="ri-checkbox-circle-line me-1"></i>All clear</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-backend-layout>
