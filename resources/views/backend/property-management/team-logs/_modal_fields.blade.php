{{-- Reusable Team Log modal fields --}}
@php $isTemplate = $isTemplate ?? false; $lv = fn($f) => (!$isTemplate && $log) ? ($log->$f ?? '') : ''; @endphp

<div class="row g-sm-4 g-3">
    <div class="col-md-5">
        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase">
            <i class="ri-user-star-line me-1 text-primary"></i> Team Member <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="ri-user-fill text-muted fs-13"></i></span>
            <input type="text" name="member_name" class="form-control" value="{{ $lv('member_name') }}" placeholder="Enter name" required>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase">
            <i class="ri-calendar-line me-1 text-primary"></i> Work Date <span class="text-danger">*</span>
        </label>
        <input type="date" name="date" class="form-control" value="{{ $isTemplate ? '' : ($lv('date') ?: date('Y-m-d')) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase">
            <i class="ri-time-line me-1 text-primary"></i> Shift <span class="text-danger">*</span>
        </label>
        <select name="shift_type" class="form-select border-primary border-opacity-25" required>
            <option value="Full"  {{ $lv('shift_type') === 'Full'  ? 'selected' : '' }}>Full Day</option>
            <option value="Half"  {{ $lv('shift_type') === 'Half'  ? 'selected' : '' }}>Half Day</option>
        </select>
    </div>

    <div class="col-12">
        <div class="p-sm-3 p-2 rounded-3 bg-light border border-dashed">
            <div class="row g-3 align-items-end">
                {{-- Searchable Property Select --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase">
                        <i class="ri-map-pin-user-line me-1 text-primary"></i> Assigned Site <span class="text-danger">*</span>
                    </label>
                    <select name="site_id" class="form-select prop-autofill-select" style="width:100%"
                        data-placeholder="— Search Property —" required>
                        <option value=""></option>
                        @foreach($properties as $prop)
                            <option value="{{ $prop->id }}"
                                {{ $lv('site_id') == $prop->id ? 'selected' : '' }}
                                data-address="{{ $prop->address }}"
                                data-client="{{ $prop->client_name }}"
                                data-company="{{ $prop->client_company }}"
                                data-phone="{{ $prop->client_phone }}"
                                data-tenant="{{ $prop->tenant_name }}"
                                data-landlord="{{ $prop->landlord_name }}">
                                {{ $prop->address }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase">
                        <i class="ri-money-pound-circle-line me-1 text-success"></i> Daily Pay <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-success-transparent text-success border-success border-opacity-25">$</span>
                        <input type="number" name="daily_pay" step="0.01" min="0"
                            class="form-control border-success border-opacity-25 fw-bold"
                            value="{{ $lv('daily_pay') ?: '0.00' }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-switch card-body bg-white rounded border border-success border-opacity-10 py-2 px-sm-3 px-2 ms-sm-2 ms-0 mb-1 shadow-sm">
                        <input class="form-check-input ms-0" type="checkbox" name="is_paid"
                            id="isPaid_{{ $isTemplate ? 'tpl' : 'frm' }}" value="1"
                            {{ (!$isTemplate && $log && $log->is_paid) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-success fs-12 ms-2 mb-0 cursor-pointer"
                            for="isPaid_{{ $isTemplate ? 'tpl' : 'frm' }}">
                            Is Paid?
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Property Info Card (auto-fills on selection) --}}
    <div class="col-12 prop-info-card" style="display:none">
        <div class="rounded-3 border border-success border-opacity-25 bg-success-transparent p-3">
            <div class="d-flex align-items-center mb-2">
                <span class="fs-12 fw-bold text-success text-uppercase">
                    <i class="ri-community-line me-1"></i>Selected Property Info
                </span>
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
                    <span class="fs-11 text-muted fw-semibold d-block text-uppercase">Phone</span>
                    <span class="fs-12 text-dark prop-info-phone">—</span>
                </div>
                <div class="col-md-4 col-6">
                    <span class="fs-11 text-muted fw-semibold d-block text-uppercase">Tenant</span>
                    <span class="fs-12 text-dark prop-info-tenant">—</span>
                </div>
            </div>
        </div>
    </div>
</div>
