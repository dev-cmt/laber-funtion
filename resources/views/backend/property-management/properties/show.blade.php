<x-backend-layout title="Property Details">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-bold fs-20 mb-1">Property Profile</h1>
            <p class="text-muted fs-12 mb-0">Detailed overview of property, compliance, and associated jobs.</p>
        </div>
        <div class="ms-md-1 ms-0 mt-md-0 mt-2">
            <div class="btn-list">
                <a href="{{ route('properties-management.index') }}" class="btn btn-light border btn-wave">
                    <i class="ri-arrow-left-line me-1"></i> Back to List
                </a>
                <a href="{{ route('properties-management.index') }}" class="btn btn-warning btn-wave text-white">
                    <i class="ri-edit-line me-1"></i> Edit Details
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Hero Card / Address --}}
        <div class="col-xl-12">
            <div class="card custom-card shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <div class="bg-primary-transparent p-4 d-flex align-items-center">
                        <div class="avatar avatar-xl bg-primary text-white rounded-3 me-3 shadow-sm">
                            <i class="ri-community-line fs-24"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-primary">{{ $property->address }}</h4>
                            <div class="d-flex flex-wrap gap-3">
                                <span class="fs-13 text-muted"><i class="ri-user-line me-1 text-primary"></i>Client: {{ $property->client_name ?: 'N/A' }}</span>
                                <span class="fs-13 text-muted"><i class="ri-phone-line me-1 text-primary"></i>Contact: {{ $property->client_phone ?: 'N/A' }}</span>
                                <span class="fs-13 text-muted"><i class="ri-briefcase-line me-1 text-primary"></i>Company: {{ $property->client_company ?: 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Entity Info Cards --}}
        <div class="col-xl-4">
            <div class="card custom-card shadow-sm border-0 h-100">
                <div class="card-header bg-light-transparent py-2 border-bottom">
                    <div class="card-title text-primary fs-14 fw-bold"><i class="ri-user-settings-line me-2"></i>Client Information</div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted fs-13">ID / Reference</span>
                            <span class="fw-semibold">{{ $property->client_no ?: '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted fs-13">Email</span>
                            <span class="text-primary">{{ $property->client_email ?: '—' }}</span>
                        </li>
                        <li class="list-group-item px-0 py-2 border-0">
                            <span class="text-muted fs-13 d-block mb-1">Office Address</span>
                            <span class="fw-medium text-dark small">{{ $property->client_address ?: '—' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card custom-card shadow-sm border-0 h-100">
                <div class="card-header bg-success-transparent py-2 border-bottom">
                    <div class="card-title text-success fs-14 fw-bold"><i class="ri-home-smile-2-line me-2"></i>Tenant Information</div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted fs-13">Name</span>
                            <span class="fw-semibold">{{ $property->tenant_name ?: '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted fs-13">Contact No.</span>
                            <span class="fw-semibold">{{ $property->tenant_no ?: '—' }}</span>
                        </li>
                    </ul>
                    <div class="mt-3 p-3 bg-light rounded text-center">
                        <p class="text-muted fs-12 mb-0">Current active tenancy</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card custom-card shadow-sm border-0 h-100">
                <div class="card-header bg-warning-transparent py-2 border-bottom">
                    <div class="card-title text-warning fs-14 fw-bold"><i class="ri-bank-card-line me-2"></i>Landlord Information</div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted fs-13">Name</span>
                            <span class="fw-semibold">{{ $property->landlord_name ?: '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted fs-13">Contact</span>
                            <span class="fw-semibold">{{ $property->landlord_no ?: '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted fs-13">Email</span>
                            <span class="text-warning fw-medium">{{ $property->landlord_email ?: '—' }}</span>
                        </li>
                        <li class="list-group-item px-0 py-2 border-0">
                            <span class="text-muted fs-13 d-block mb-1">Mailing Address</span>
                            <span class="fw-medium text-dark small">{{ $property->landlord_address ?: '—' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Compliance Grid --}}
        <div class="col-xl-12">
            <div class="card custom-card shadow-sm border-0">
                <div class="card-header bg-danger-transparent py-2 border-bottom">
                    <div class="card-title text-danger fs-14 fw-bold"><i class="ri-shield-check-line me-2"></i>Compliance Status</div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @php
                            $certs = [
                                ['label' => 'Gas Certificate', 'date' => $property->gas_cert_expiry, 'icon' => 'ri-fire-line', 'color' => 'orange'],
                                ['label' => 'Electrical Cert', 'date' => $property->electric_cert_expiry, 'icon' => 'ri-flashlight-line', 'color' => 'warning'],
                                ['label' => 'Fire Alarm', 'date' => $property->fire_alarm_expiry, 'icon' => 'ri-alarm-warning-line', 'color' => 'danger'],
                                ['label' => 'Emergency Lighting', 'date' => $property->emergency_light_expiry, 'icon' => 'ri-lightbulb-flash-line', 'color' => 'info'],
                                ['label' => 'EPC Rating', 'date' => $property->epc_expiry, 'icon' => 'ri-leaf-line', 'color' => 'success'],
                                ['label' => 'PAT Testing', 'date' => $property->pat_testing_expiry, 'icon' => 'ri-plug-line', 'color' => 'primary'],
                            ];
                        @endphp
                        @foreach($certs as $c)
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="p-3 border rounded-3 bg-white shadow-sm text-center border-dashed">
                                <div class="avatar avatar-md bg-{{ $c['color'] }}-transparent text-{{ $c['color'] }} mb-2 rounded-circle">
                                    <i class="{{ $c['icon'] }} fs-18"></i>
                                </div>
                                <div class="text-muted fw-bold fs-11 mb-1 text-uppercase">{{ $c['label'] }}</div>
                                @if($c['date'])
                                    @php $isPast = \Carbon\Carbon::parse($c['date'])->isPast(); @endphp
                                    <h6 class="mb-0 fw-bold {{ $isPast ? 'text-danger' : 'text-success' }}">
                                        {{ \Carbon\Carbon::parse($c['date'])->format('d M, Y') }}
                                    </h6>
                                    <div class="mt-1">
                                        <span class="badge {{ $isPast ? 'bg-danger' : 'bg-success' }}-transparent fs-10 rounded-pill">
                                            {{ $isPast ? 'Expired' : 'Valid' }}
                                        </span>
                                    </div>
                                @else
                                    <h6 class="mb-0 text-muted fs-12">No Record</h6>
                                    <div class="mt-1"><span class="badge bg-light text-muted fs-10 rounded-pill">Pending</span></div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Associated Jobs --}}
        <div class="col-xl-12">
            <div class="card custom-card shadow-sm border-0 overflow-hidden">
                <div class="card-header justify-content-between align-items-center">
                    <div class="card-title fw-bold fs-14">
                        <i class="ri-briefcase-line me-1"></i> Maintenance History & Jobs
                    </div>
                    <a href="{{ route('managed-jobs.index') }}?property_id={{ $property->id }}" class="btn btn-sm btn-primary-transparent fw-bold">
                        <i class="ri-add-line"></i> Manage Jobs
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-muted fs-11 text-uppercase fw-bold">
                                    <th class="ps-4">Date</th>
                                    <th>Job Details</th>
                                    <th>Status</th>
                                    <th>Total Value</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($property->managedJobs()->latest()->get() as $job)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark">{{ $job->scheduled_at ? $job->scheduled_at->format('d M Y') : '—' }}</span>
                                            <small class="text-muted">{{ $job->scheduled_at ? $job->scheduled_at->format('H:i') : '' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted fs-12" style="max-width:350px;white-space:normal">
                                            {{ Str::limit($job->job_details, 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        @php 
                                            $st = match($job->status) {
                                                'Completed' => 'success',
                                                'Cancelled' => 'danger',
                                                'In Progress' => 'warning',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $st }}-transparent rounded-pill fs-11">{{ $job->status }}</span>
                                    </td>
                                    <td><span class="fw-bold text-primary">${{ number_format($job->total_price, 2) }}</span></td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('managed-jobs.show', $job) }}" class="btn btn-sm btn-icon btn-light border rounded-pill" title="View Details"><i class="ri-arrow-right-line"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">No maintenance jobs recorded for this property.</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-backend-layout>
