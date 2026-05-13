<x-backend-layout title="Properties">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between my-4 flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-bold fs-18 mb-1">
                <i class="ri-community-line me-2 text-primary"></i>Properties Management
            </h1>
            <ol class="breadcrumb mb-0 fs-12">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Properties</li>
            </ol>
        </div>
        <button type="button" class="btn btn-primary btn-wave waves-light fw-semibold px-4"
            data-bs-toggle="modal" data-bs-target="#createPropertyModal">
            <i class="ri-add-circle-fill me-2 align-middle"></i> Add New Property
        </button>
    </div>

    {{-- Alert messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="ri-checkbox-circle-line me-2 fs-16"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Properties Table Card --}}
    <div class="card custom-card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-15 fw-bold text-dark">Properties List</span>
                    <span class="badge bg-primary rounded-pill">{{ $properties->total() }}</span>
                </div>
                <div class="d-flex gap-2">
                    <div class="input-group input-group-sm" style="width:200px">
                        <span class="input-group-text bg-white border-end-0"><i class="ri-search-line text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Search..." id="propertySearch">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap" id="propertiesTable">
                    <thead style="background:#f8f9fc;">
                        <tr class="text-muted fs-12 fw-semibold text-uppercase">
                            <th class="ps-4 py-3" style="width:50px">#</th>
                            <th class="py-3">Property Address</th>
                            <th class="py-3">Client / Company</th>
                            <th class="py-3">Tenant</th>
                            <th class="py-3">Landlord</th>
                            <th class="py-3 text-center">Certificates</th>
                            <th class="pe-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $i => $property)
                        <tr class="property-row" data-address="{{ strtolower($property->address) }}">
                            <td class="ps-4 text-muted fs-12 fw-medium">{{ $properties->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle flex-shrink-0"
                                        style="width:36px;height:36px;display:flex;align-items:center;justify-content:center">
                                        <i class="ri-community-line fs-16"></i>
                                    </div>
                                    <div style="max-width:220px;white-space:normal;min-width:120px">
                                        <a href="{{ route('properties-management.show', $property) }}"
                                            class="fw-semibold text-dark d-block lh-sm"
                                            style="font-size:13px">{{ $property->address }}</a>
                                        @if($property->client_phone)
                                        <span class="text-muted fs-11"><i class="ri-phone-line me-1"></i>{{ $property->client_phone }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark fs-13">{{ $property->client_name ?: '—' }}</div>
                                <small class="text-muted">{{ $property->client_company ?: '' }}</small>
                            </td>
                            <td>
                                @if($property->tenant_name)
                                <div class="d-flex align-items-center gap-1">
                                    <div class="avatar avatar-xs bg-success-transparent text-success rounded-circle"
                                        style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700">
                                        {{ strtoupper(substr($property->tenant_name, 0, 1)) }}
                                    </div>
                                    <span class="fs-13">{{ $property->tenant_name }}</span>
                                </div>
                                @else
                                <span class="text-muted fs-13">—</span>
                                @endif
                            </td>
                            <td>
                                @if($property->landlord_name)
                                <div class="d-flex align-items-center gap-1">
                                    <div class="avatar avatar-xs bg-warning-transparent text-warning rounded-circle"
                                        style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700">
                                        {{ strtoupper(substr($property->landlord_name, 0, 1)) }}
                                    </div>
                                    <span class="fs-13">{{ $property->landlord_name }}</span>
                                </div>
                                @else
                                <span class="text-muted fs-13">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                    @foreach([
                                        'gas_cert_expiry'        => ['G','Gas'],
                                        'electric_cert_expiry'   => ['E','Electric'],
                                        'epc_expiry'             => ['EPC','EPC'],
                                        'pat_testing_expiry'     => ['P','PAT'],
                                        'fire_alarm_expiry'      => ['F','Fire Alarm'],
                                    ] as $cert => [$short, $label])
                                        @php $date = $property->$cert; @endphp
                                        @if($date)
                                            @php
                                                $isPast   = \Carbon\Carbon::parse($date)->isPast();
                                                $isSoon   = !$isPast && \Carbon\Carbon::parse($date)->diffInDays(now()) < 30;
                                                $badgeCls = $isPast ? 'bg-danger' : ($isSoon ? 'bg-warning' : 'bg-success');
                                            @endphp
                                            <span class="badge {{ $badgeCls }}-transparent rounded-pill fs-10 border border-1"
                                                data-bs-toggle="tooltip"
                                                title="{{ $label }}: {{ \Carbon\Carbon::parse($date)->format('d M Y') }}">
                                                {{ $short }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-transparent text-muted rounded-pill fs-10"
                                                data-bs-toggle="tooltip" title="{{ $label }}: No Data">—</span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('properties-management.show', $property) }}"
                                        class="btn btn-sm btn-icon btn-info-transparent rounded-circle" title="View Details">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <button class="btn btn-sm btn-icon btn-warning-transparent rounded-circle edit-property-btn"
                                        data-bs-toggle="modal" data-bs-target="#editPropertyModal"
                                        data-property="{{ json_encode($property) }}" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('properties-management.destroy', $property) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this property?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-icon btn-danger-transparent rounded-circle" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="ri-community-line fs-48 text-muted opacity-50 d-block mb-3"></i>
                                    <p class="text-muted fs-14 mb-1 fw-medium">No Properties Found</p>
                                    <p class="text-muted fs-12 mb-3">Start by adding your first property to manage.</p>
                                    <button class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#createPropertyModal">
                                        <i class="ri-add-line me-1"></i> Add Property
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($properties->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $properties->links('backend.pagination.custom') }}
        </div>
        @endif
    </div>

    {{-- CREATE MODAL --}}
    <div class="modal fade" id="createPropertyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('properties-management.store') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white py-3 px-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-add-circle-fill fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Add New Property</h5>
                                <p class="mb-0 fs-11 opacity-75">Fill in all details to register a new property</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" style="max-height: 70vh; overflow-y: auto; background:#f8f9fc">
                        @include('backend.property-management.properties._modal_fields', ['p' => null])
                    </div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Save Property
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editPropertyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form id="editPropertyForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header text-white py-3 px-4" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-edit-circle-fill fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Update Property</h5>
                                <p class="mb-0 fs-11 opacity-75">Modify property details and save changes</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" id="editPropertyModalBody" style="max-height: 70vh; overflow-y: auto; background:#f8f9fc">
                        <div class="text-center py-5">
                            <div class="spinner-border text-warning" role="status"></div>
                            <p class="mt-2 text-muted fs-13">Loading property details...</p>
                        </div>
                    </div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background: linear-gradient(135deg, #f59e0b, #ef4444); border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Update Property
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="propertyFieldsTemplate">
        @include('backend.property-management.properties._modal_fields', ['p' => null, 'isTemplate' => true])
    </template>

    @push('js')
    <script>
    $(document).ready(function () {
        // Live search
        $('#propertySearch').on('keyup', function () {
            const q = $(this).val().toLowerCase();
            $('.property-row').each(function () {
                $(this).toggle($(this).data('address').includes(q));
            });
        });

        // Edit modal
        $('.edit-property-btn').on('click', function () {
            const p = $(this).data('property');
            $('#editPropertyForm').attr('action', "{{ route('properties-management.update', ':id') }}".replace(':id', p.id));
            const html = document.getElementById('propertyFieldsTemplate').innerHTML;
            $('#editPropertyModalBody').html(html);
            const fields = [
                'address','client_name','client_no','client_phone','client_company','client_address','client_email',
                'tenant_name','tenant_no','landlord_name','landlord_no','landlord_address','landlord_email',
                'gas_cert_expiry','electric_cert_expiry','fire_alarm_expiry','emergency_light_expiry','epc_expiry','pat_testing_expiry'
            ];
            fields.forEach(f => {
                const $el = $('#editPropertyModalBody').find(`[name="${f}"]`);
                if ($el.length) $el.val(p[f] ?? '');
            });
        });

        // Tooltips
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
    });
    </script>
    @endpush
</x-backend-layout>
