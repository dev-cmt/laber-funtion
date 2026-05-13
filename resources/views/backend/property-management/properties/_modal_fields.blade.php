{{-- Reusable property form fields for modals --}}
@php $isTemplate = $isTemplate ?? false; $pv = fn($f) => (!$isTemplate && $p) ? ($p->$f ?? '') : ''; @endphp

<div class="row g-sm-4 g-3">
    {{-- Address Section --}}
    <div class="col-12">
        <div class="p-3 rounded-3 bg-primary-transparent border border-primary border-opacity-10">
            <label class="form-label fw-bold text-primary fs-14 mb-2">
                <i class="ri-map-pin-2-fill me-1"></i> Full Property Address <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="ri-community-line text-muted"></i></span>
                <input type="text" name="address" class="form-control border-start-0 ps-0" value="{{ $pv('address') }}" placeholder="e.g. 10 Baker Street, London, NW1 6XE" required>
            </div>
        </div>
    </div>

    {{-- Client Information --}}
    <div class="col-12">
        <div class="card custom-card border shadow-none mb-0">
            <div class="card-header bg-light py-2">
                <div class="card-title fs-13 fw-semibold text-primary">
                    <i class="ri-user-settings-line me-1"></i> Client Information
                </div>
            </div>
            <div class="card-body p-sm-3 p-2">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Client Name</label>
                        <input type="text" name="client_name" class="form-control form-control-sm" value="{{ $pv('client_name') }}" placeholder="Full Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Client ID/No.</label>
                        <input type="text" name="client_no" class="form-control form-control-sm" value="{{ $pv('client_no') }}" placeholder="Reference #">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Phone Number</label>
                        <input type="text" name="client_phone" class="form-control form-control-sm" value="{{ $pv('client_phone') }}" placeholder="+44 ...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Company Name</label>
                        <input type="text" name="client_company" class="form-control form-control-sm" value="{{ $pv('client_company') }}" placeholder="Company Ltd">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Email Address</label>
                        <input type="email" name="client_email" class="form-control form-control-sm" value="{{ $pv('client_email') }}" placeholder="email@example.com">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Client Address</label>
                        <input type="text" name="client_address" class="form-control form-control-sm" value="{{ $pv('client_address') }}" placeholder="Mailing Address">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tenant & Landlord Section --}}
    <div class="col-md-6">
        <div class="card custom-card border shadow-none h-100 mb-0">
            <div class="card-header bg-success-transparent py-2 border-bottom-0">
                <div class="card-title fs-13 fw-semibold text-success">
                    <i class="ri-home-smile-2-line me-1"></i> Tenant Details
                </div>
            </div>
            <div class="card-body p-sm-3 p-2">
                <div class="row g-2">
                    <div class="col-12">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Tenant Name</label>
                        <input type="text" name="tenant_name" class="form-control form-control-sm" value="{{ $pv('tenant_name') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Tenant Phone/No.</label>
                        <input type="text" name="tenant_no" class="form-control form-control-sm" value="{{ $pv('tenant_no') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card custom-card border shadow-none h-100 mb-0">
            <div class="card-header bg-warning-transparent py-2 border-bottom-0">
                <div class="card-title fs-13 fw-semibold text-warning">
                    <i class="ri-bank-card-line me-1"></i> Landlord Details
                </div>
            </div>
            <div class="card-body p-sm-3 p-2">
                <div class="row g-2">
                    <div class="col-12">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Landlord Name</label>
                        <input type="text" name="landlord_name" class="form-control form-control-sm" value="{{ $pv('landlord_name') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Landlord Contact</label>
                        <input type="text" name="landlord_no" class="form-control form-control-sm" value="{{ $pv('landlord_no') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fs-12 fw-medium text-muted mb-1">Landlord Email</label>
                        <input type="email" name="landlord_email" class="form-control form-control-sm" value="{{ $pv('landlord_email') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Compliance Section --}}
    <div class="col-12">
        <div class="card custom-card border shadow-none mb-0">
            <div class="card-header bg-danger-transparent py-2">
                <div class="card-title fs-13 fw-semibold text-danger">
                    <i class="ri-shield-check-line me-1"></i> Compliance & Safety Certificates (Expiry Dates)
                </div>
            </div>
            <div class="card-body p-sm-3 p-2">
                <div class="row g-3">
                    @php
                        $certFields = [
                            'gas_cert_expiry'        => ['Gas Cert', 'ri-fire-line text-orange'],
                            'electric_cert_expiry'   => ['Electrical', 'ri-flashlight-line text-warning'],
                            'fire_alarm_expiry'      => ['Fire Alarm', 'ri-alarm-warning-line text-danger'],
                            'emergency_light_expiry' => ['Emerg. Light', 'ri-lightbulb-flash-line text-info'],
                            'epc_expiry'             => ['EPC Rating', 'ri-leaf-line text-success'],
                            'pat_testing_expiry'     => ['PAT Test', 'ri-plug-line text-primary'],
                        ];
                    @endphp
                    @foreach($certFields as $field => $data)
                    <div class="col-md-4 col-sm-6">
                        <label class="form-label fs-11 fw-bold text-uppercase text-muted mb-1">
                            <i class="{{ $data[1] }} me-1"></i> {{ $data[0] }}
                        </label>
                        <input type="date" name="{{ $field }}" class="form-control form-control-sm border-dashed"
                            value="{{ (!$isTemplate && $p && $p->$field) ? \Carbon\Carbon::parse($p->$field)->format('Y-m-d') : '' }}">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
