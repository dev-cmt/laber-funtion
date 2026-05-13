{{-- Reusable Daily Finance modal fields --}}
@php $isTemplate = $isTemplate ?? false; $fv = fn($f) => (!$isTemplate && $fin) ? ($fin->$f ?? '') : ''; @endphp

<div class="row g-sm-4 g-3">
    {{-- Header Info --}}
    <div class="col-md-5">
        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase"><i class="ri-price-tag-3-line me-1 text-primary"></i> Category / Type <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="ri-list-settings-line text-muted"></i></span>
            <input type="text" name="expense_type" list="expense-cats" class="form-control"
                value="{{ $fv('expense_type') }}" placeholder="Search or type..." required>
        </div>
        <datalist id="expense-cats">
            <option value="Materials"><option value="Labour"><option value="Fuel">
            <option value="Equipment"><option value="Subcontractor"><option value="Invoice Payment"><option value="Miscellaneous">
        </datalist>
    </div>
    <div class="col-md-3">
        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase"><i class="ri-calendar-line me-1 text-primary"></i> Record Date <span class="text-danger">*</span></label>
        <input type="date" name="date" class="form-control" value="{{ $isTemplate ? '' : ($fv('date') ?: date('Y-m-d')) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase">
            <i class="ri-building-line me-1 text-primary"></i> Related Property
        </label>
        <select name="site_id" class="form-select prop-autofill-select" style="width:100%"
            data-placeholder="— General / No Site —">
            <option value=""></option>
            @foreach($properties as $prop)
                <option value="{{ $prop->id }}"
                    {{ $fv('site_id') == $prop->id ? 'selected' : '' }}
                    data-address="{{ $prop->address }}"
                    data-client="{{ $prop->client_name }}"
                    data-company="{{ $prop->client_company }}"
                    data-phone="{{ $prop->client_phone }}"
                    data-tenant="{{ $prop->tenant_name }}"
                    data-landlord="{{ $prop->landlord_name }}">
                    {{ Str::limit($prop->address, 50) }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Property Info Card (auto-fills on selection) --}}
    <div class="col-12 prop-info-card" style="display:none">
        <div class="rounded-3 border border-info border-opacity-25 bg-info-transparent p-3">
            <span class="fs-12 fw-bold text-info text-uppercase d-block mb-2">
                <i class="ri-community-line me-1"></i>Selected Property Info
            </span>
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

    {{-- Cash Flow Card --}}
    <div class="col-md-6">
        <div class="card custom-card border-success border-opacity-10 shadow-none mb-0 bg-success-transparent h-100">
            <div class="card-header bg-success text-white py-2 border-bottom-0 rounded-top">
                <div class="card-title fs-13 fw-bold"><i class="ri-hand-coin-line me-1"></i> Cash Flow (Physical)</div>
            </div>
            <div class="card-body p-sm-3 p-2">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fs-11 fw-bold text-success mb-1">CASH IN (+)</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white">$</span>
                            <input type="number" name="cash_in" step="0.01" min="0" class="form-control fw-semibold" value="{{ $fv('cash_in') ?: '0.00' }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fs-11 fw-bold text-danger mb-1">CASH OUT (-)</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white">$</span>
                            <input type="number" name="cash_out" step="0.01" min="0" class="form-control fw-semibold text-danger" value="{{ $fv('cash_out') ?: '0.00' }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fs-11 fw-bold text-muted mb-1">CASH REFUND</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white text-muted">$</span>
                            <input type="number" name="cash_refund" step="0.01" min="0" class="form-control" value="{{ $fv('cash_refund') ?: '0.00' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Account Flow Card --}}
    <div class="col-md-6">
        <div class="card custom-card border-primary border-opacity-10 shadow-none mb-0 bg-primary-transparent h-100">
            <div class="card-header bg-primary text-white py-2 border-bottom-0 rounded-top">
                <div class="card-title fs-13 fw-bold"><i class="ri-bank-card-line me-1"></i> Bank / Account Flow</div>
            </div>
            <div class="card-body p-sm-3 p-2">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fs-11 fw-bold text-primary mb-1">ACCOUNT IN (+)</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white">$</span>
                            <input type="number" name="acc_in" step="0.01" min="0" class="form-control fw-semibold" value="{{ $fv('acc_in') ?: '0.00' }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fs-11 fw-bold text-danger mb-1">ACCOUNT OUT (-)</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white">$</span>
                            <input type="number" name="acc_out" step="0.01" min="0" class="form-control fw-semibold text-danger" value="{{ $fv('acc_out') ?: '0.00' }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fs-11 fw-bold text-muted mb-1">ACC REFUND</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white text-muted">$</span>
                            <input type="number" name="acc_refund" step="0.01" min="0" class="form-control" value="{{ $fv('acc_refund') ?: '0.00' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
