{{-- Reusable Job modal fields --}}
@php $isTemplate = $isTemplate ?? false; $jv = fn($f) => (!$isTemplate && $job) ? ($job->$f ?? '') : ''; @endphp

<div class="row g-sm-4 g-3">

    {{-- Property & Status --}}
    <div class="col-md-8">
        <label class="form-label fw-bold text-muted fs-12 mb-1">
            <i class="ri-map-pin-line me-1 text-primary"></i>Property / Site <span class="text-danger">*</span>
        </label>
        <select name="property_id" class="form-select prop-autofill-select" required
            style="width:100%" data-placeholder="— Search & Select Property —">
            <option value=""></option>
            @foreach($properties as $prop)
                <option value="{{ $prop->id }}"
                    {{ $jv('property_id') == $prop->id ? 'selected' : '' }}
                    data-address="{{ $prop->address }}"
                    data-client="{{ $prop->client_name }}"
                    data-company="{{ $prop->client_company }}"
                    data-phone="{{ $prop->client_phone }}"
                    data-email="{{ $prop->client_email }}"
                    data-tenant="{{ $prop->tenant_name }}"
                    data-landlord="{{ $prop->landlord_name }}">
                    {{ $prop->address }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted fs-12 mb-1">
            <i class="ri-flag-line me-1 text-primary"></i>Status <span class="text-danger">*</span>
        </label>
        <select name="status" class="form-select border-primary border-opacity-25" required>
            @foreach(['Pending','In Progress','Completed','Cancelled'] as $s)
                <option value="{{ $s }}" {{ $jv('status') === $s ? 'selected' : ($s === 'Pending' && !$jv('status') ? 'selected' : '') }}>{{ $s }}</option>
            @endforeach
        </select>
    </div>

    {{-- Property Info Card (auto-fills on selection) --}}
    <div class="col-12 prop-info-card" style="display:none">
        <div class="rounded-3 border border-primary border-opacity-25 bg-primary-transparent p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fs-12 fw-bold text-primary text-uppercase">
                    <i class="ri-information-line me-1"></i>Selected Property Details
                </span>
                <span class="badge bg-primary-transparent text-primary rounded-pill fs-10 prop-info-id"></span>
            </div>
            <div class="row g-2">
                <div class="col-12">
                    <span class="fs-11 text-muted fw-semibold d-block text-uppercase">Address</span>
                    <span class="fs-13 fw-semibold text-dark prop-info-address">—</span>
                </div>
                <div class="col-md-4 col-6">
                    <span class="fs-11 text-muted fw-semibold d-block text-uppercase">Client</span>
                    <span class="fs-12 text-dark prop-info-client">—</span>
                </div>
                <div class="col-md-4 col-6">
                    <span class="fs-11 text-muted fw-semibold d-block text-uppercase">Company</span>
                    <span class="fs-12 text-dark prop-info-company">—</span>
                </div>
                <div class="col-md-4 col-6">
                    <span class="fs-11 text-muted fw-semibold d-block text-uppercase">Phone</span>
                    <span class="fs-12 text-dark prop-info-phone">—</span>
                </div>
                <div class="col-md-4 col-6">
                    <span class="fs-11 text-muted fw-semibold d-block text-uppercase">Tenant</span>
                    <span class="fs-12 text-dark prop-info-tenant">—</span>
                </div>
                <div class="col-md-4 col-6">
                    <span class="fs-11 text-muted fw-semibold d-block text-uppercase">Landlord</span>
                    <span class="fs-12 text-dark prop-info-landlord">—</span>
                </div>
                <div class="col-md-4 col-6">
                    <span class="fs-11 text-muted fw-semibold d-block text-uppercase">Email</span>
                    <span class="fs-12 text-dark prop-info-email">—</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Timing & Staff --}}
    <div class="col-md-6">
        <div class="p-sm-3 p-2 rounded bg-light border border-dashed h-100">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fs-12 fw-semibold mb-1">Scheduled Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control"
                        value="{{ $isTemplate ? '' : (($job && $job->scheduled_at) ? \Carbon\Carbon::parse($job->scheduled_at)->format('Y-m-d\TH:i') : '') }}">
                </div>
                <div class="col-12">
                    <label class="form-label fs-12 fw-semibold mb-1">Assigned / Attended By</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="ri-user-follow-line text-muted"></i></span>
                        <input type="text" name="who_attended" class="form-control" value="{{ $jv('who_attended') }}" placeholder="Staff names...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Details --}}
    <div class="col-md-6">
        <div class="p-sm-3 p-2 rounded bg-light border border-dashed h-100">
            <label class="form-label fs-12 fw-semibold mb-1">Job Description / Details</label>
            <textarea name="job_details" class="form-control" rows="5" placeholder="Enter work details here...">{{ $jv('job_details') }}</textarea>
        </div>
    </div>

    {{-- Resources --}}
    <div class="col-md-6">
        <label class="form-label fs-12 fw-bold text-muted mb-1 uppercase"><i class="ri-tools-line me-1"></i> Tools Needed</label>
        <textarea name="tools_needed" class="form-control fs-13" rows="2" placeholder="List specific tools...">{{ $jv('tools_needed') }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label fs-12 fw-bold text-muted mb-1 uppercase"><i class="ri-stack-line me-1"></i> Materials Needed</label>
        <textarea name="materials_needed" class="form-control fs-13" rows="2" placeholder="List required materials...">{{ $jv('materials_needed') }}</textarea>
    </div>

    {{-- Financials --}}
    <div class="col-12">
        <div class="card custom-card border-primary border-opacity-10 shadow-none mb-0 bg-primary-transparent">
            <div class="card-header border-bottom-0 pb-0">
                <div class="card-title text-primary fs-14 fw-bold">
                    <i class="ri-money-pound-circle-line me-1"></i> Financial Breakdown
                </div>
            </div>
            <div class="card-body p-sm-3 p-2 pt-2">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fs-12 fw-medium mb-1">Agreed Price</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">$</span>
                            <input type="number" name="agreed_price" step="0.01" class="form-control job-calc"
                                value="{{ $jv('agreed_price') ?: '0.00' }}" oninput="calcTotal(this.closest('.modal-body'))">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fs-12 fw-medium mb-1">VAT</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">$</span>
                            <input type="number" name="vat" step="0.01" class="form-control job-calc"
                                value="{{ $jv('vat') ?: '0.00' }}" oninput="calcTotal(this.closest('.modal-body'))">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fs-12 fw-bold text-primary mb-1">Total Price</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-primary text-white border-primary">$</span>
                            <input type="number" name="total_price" step="0.01" class="form-control fw-bold border-primary"
                                value="{{ $jv('total_price') ?: '0.00' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3 d-none d-md-block"></div>

                    <div class="col-md-4">
                        <label class="form-label fs-12 fw-medium mb-1 text-success">Cash Received</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-success-transparent">$</span>
                            <input type="number" name="cash_payment_received" step="0.01" class="form-control border-success border-opacity-25"
                                value="{{ $jv('cash_payment_received') ?: '0.00' }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fs-12 fw-medium mb-1 text-success">Account Received</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-success-transparent">$</span>
                            <input type="number" name="acc_payment_received" step="0.01" class="form-control border-success border-opacity-25"
                                value="{{ $jv('acc_payment_received') ?: '0.00' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
