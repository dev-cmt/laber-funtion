<x-backend-layout title="Managed Jobs">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between my-4 flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-bold fs-18 mb-1">
                <i class="ri-tools-line me-2 text-primary"></i>Managed Jobs
            </h1>
            <ol class="breadcrumb mb-0 fs-12">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Jobs</li>
            </ol>
        </div>
        <button type="button" class="btn btn-primary btn-wave waves-light fw-semibold px-4"
            data-bs-toggle="modal" data-bs-target="#createJobModal">
            <i class="ri-add-circle-fill me-2 align-middle"></i> Add New Job
        </button>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="ri-checkbox-circle-line me-2 fs-16"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Summary Stats --}}
    <div class="row g-3 mb-4">
        @php
            $allJobs    = $jobs->getCollection();
            $totalJobs  = $jobs->total();
            $completed  = \App\Models\ManagedJob::where('status','Completed')->count();
            $pending    = \App\Models\ManagedJob::where('status','Pending')->count();
            $inProgress = \App\Models\ManagedJob::where('status','In Progress')->count();
        @endphp
        @foreach([
            ['label'=>'Total Jobs',   'val'=>$totalJobs,  'color'=>'primary', 'icon'=>'ri-briefcase-line'],
            ['label'=>'Completed',    'val'=>$completed,  'color'=>'success', 'icon'=>'ri-checkbox-circle-line'],
            ['label'=>'In Progress',  'val'=>$inProgress, 'color'=>'warning', 'icon'=>'ri-loader-4-line'],
            ['label'=>'Pending',      'val'=>$pending,    'color'=>'danger',  'icon'=>'ri-time-line'],
        ] as $stat)
        <div class="col-6 col-md-3">
            <div class="card custom-card border-0 shadow-sm rounded-4 h-100 mb-0">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar avatar-md rounded-3 bg-{{ $stat['color'] }}-transparent text-{{ $stat['color'] }}"
                            style="width:44px;height:44px;display:flex;align-items:center;justify-content:center">
                            <i class="{{ $stat['icon'] }} fs-20"></i>
                        </div>
                        <div>
                            <p class="text-muted fs-11 fw-semibold text-uppercase mb-0">{{ $stat['label'] }}</p>
                            <h4 class="fw-bold mb-0 text-{{ $stat['color'] }}">{{ $stat['val'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Jobs Table --}}
    <div class="card custom-card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-15 fw-bold text-dark">Job Ledger</span>
                    <span class="badge bg-primary rounded-pill">{{ $jobs->total() }}</span>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <select class="form-select form-select-sm border-0 bg-light" id="statusFilter" style="width:140px">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8f9fc;">
                        <tr class="text-muted fs-12 fw-semibold text-uppercase">
                            <th class="ps-4 py-3" style="width:50px">#</th>
                            <th class="py-3">Property / Site</th>
                            <th class="py-3">Scheduled</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Attended By</th>
                            <th class="py-3 text-end">Agreed</th>
                            <th class="py-3 text-end">VAT</th>
                            <th class="py-3 text-end">Total</th>
                            <th class="py-3 text-end">Received</th>
                            <th class="pe-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $i => $job)
                        @php
                            $statusMap = [
                                'Completed'   => ['bg-success','ri-checkbox-circle-line'],
                                'Cancelled'   => ['bg-danger','ri-close-circle-line'],
                                'In Progress' => ['bg-warning','ri-loader-4-line'],
                                'Pending'     => ['bg-secondary','ri-time-line'],
                            ];
                            [$badgeCls, $icon] = $statusMap[$job->status] ?? ['bg-secondary','ri-question-line'];
                        @endphp
                        <tr class="job-row" data-status="{{ $job->status }}">
                            <td class="ps-4 text-muted fs-12 fw-medium">{{ $jobs->firstItem() + $i }}</td>
                            <td>
                                <div style="max-width:200px;white-space:normal;min-width:120px">
                                    <a href="{{ route('properties-management.show', $job->property_id) }}"
                                        class="fw-semibold text-dark d-block fs-13 lh-sm">
                                        {{ Str::limit($job->property->address ?? '—', 45) }}
                                    </a>
                                </div>
                            </td>
                            <td>
                                @if($job->scheduled_at)
                                <span class="fs-12 text-muted"><i class="ri-calendar-line me-1"></i>{{ $job->scheduled_at->format('d M Y') }}</span><br>
                                <span class="fs-11 text-muted opacity-75">{{ $job->scheduled_at->format('H:i') }}</span>
                                @else
                                <span class="text-muted fs-12">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $badgeCls }}-transparent rounded-pill fs-11 px-3">
                                    <i class="{{ $icon }} me-1"></i>{{ $job->status }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted fs-12">
                                    <i class="ri-user-follow-line me-1 text-primary"></i>{{ Str::limit($job->who_attended ?? '—', 25) }}
                                </span>
                            </td>
                            <td class="text-end fw-medium fs-13">${{ number_format($job->agreed_price, 2) }}</td>
                            <td class="text-end text-muted fs-12">${{ number_format($job->vat, 2) }}</td>
                            <td class="text-end">
                                <span class="fw-bold text-primary fs-13">${{ number_format($job->total_price, 2) }}</span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex flex-column align-items-end gap-0">
                                    <span class="fs-11 text-success fw-medium">
                                        <i class="ri-cash-line me-1"></i>${{ number_format($job->cash_payment_received, 2) }}
                                    </span>
                                    <span class="fs-11 text-info fw-medium">
                                        <i class="ri-bank-line me-1"></i>${{ number_format($job->acc_payment_received, 2) }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('managed-jobs.show', $job) }}"
                                        class="btn btn-sm btn-icon btn-info-transparent rounded-circle" title="View">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <button class="btn btn-sm btn-icon btn-warning-transparent rounded-circle edit-job-btn"
                                        data-bs-toggle="modal" data-bs-target="#editJobModal"
                                        data-job="{{ json_encode($job) }}" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('managed-jobs.destroy', $job) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this job?')">
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
                            <td colspan="10" class="text-center py-5">
                                <div class="py-4">
                                    <i class="ri-tools-line fs-48 text-muted opacity-50 d-block mb-3"></i>
                                    <p class="text-muted fs-14 mb-1 fw-medium">No Jobs Found</p>
                                    <p class="text-muted fs-12 mb-3">Add your first managed job to get started.</p>
                                    <button class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#createJobModal">
                                        <i class="ri-add-line me-1"></i> Add Job
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($jobs->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $jobs->links('backend.pagination.custom') }}
        </div>
        @endif
    </div>

    {{-- CREATE MODAL --}}
    <div class="modal fade" id="createJobModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('managed-jobs.store') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white py-3 px-4" style="background:linear-gradient(135deg,#3b82f6,#6366f1)">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-add-circle-fill fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Create New Job</h5>
                                <p class="mb-0 fs-11 opacity-75">Record a new maintenance job or task</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" style="max-height:70vh;overflow-y:auto;background:#f8f9fc">
                        @include('backend.property-management.jobs._modal_fields', ['job' => null, 'properties' => $properties])
                    </div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background:linear-gradient(135deg,#3b82f6,#6366f1);border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Save Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editJobModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form id="editJobForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header text-white py-3 px-4" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-edit-circle-fill fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Update Job Details</h5>
                                <p class="mb-0 fs-11 opacity-75">Modify and save updated job information</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" id="editJobModalBody" style="max-height:70vh;overflow-y:auto;background:#f8f9fc"></div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background:linear-gradient(135deg,#f59e0b,#ef4444);border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Update Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="jobFieldsTemplate">
        @include('backend.property-management.jobs._modal_fields', ['job' => null, 'properties' => $properties, 'isTemplate' => true])
    </template>

    @push('js')
    <script>
    // ── Property Autofill Utility ──────────────────────────────────────────────
    function initPropAutofill(modalSelector) {
        const $modal = $(modalSelector);

        // Init Select2 inside this modal
        $modal.find('.prop-autofill-select').each(function () {
            if ($(this).data('select2')) return; // avoid double-init
            $(this).select2({
                dropdownParent: $modal,
                placeholder: $(this).data('placeholder') || '— Select Property —',
                allowClear: true,
                width: '100%',
            });
        });

        // On property change → fill info card
        $modal.on('change', '.prop-autofill-select', function () {
            const $opt    = $(this).find('option:selected');
            const val     = $(this).val();
            const $card   = $(this).closest('.row').find('.prop-info-card');

            if (!val) { $card.hide(); return; }

            $card.find('.prop-info-address').text($opt.data('address') || '—');
            $card.find('.prop-info-client').text($opt.data('client')   || '—');
            $card.find('.prop-info-company').text($opt.data('company') || '—');
            $card.find('.prop-info-phone').text($opt.data('phone')     || '—');
            $card.find('.prop-info-email').text($opt.data('email')     || '—');
            $card.find('.prop-info-tenant').text($opt.data('tenant')   || '—');
            $card.find('.prop-info-landlord').text($opt.data('landlord') || '—');
            $card.find('.prop-info-id').text('#' + val);
            $card.show();
        });

        // If a value is already selected on open (edit mode), trigger display
        $modal.find('.prop-autofill-select').each(function () {
            if ($(this).val()) $(this).trigger('change');
        });
    }

    $(document).ready(function () {
        // Init for Create modal (static fields)
        $('#createJobModal').on('shown.bs.modal', function () {
            initPropAutofill('#createJobModal');
        });

        // Status filter
        $('#statusFilter').on('change', function () {
            const val = $(this).val().toLowerCase();
            $('.job-row').each(function () {
                $(this).toggle(!val || $(this).data('status').toLowerCase() === val);
            });
        });

        // Edit modal
        $('.edit-job-btn').on('click', function () {
            const j = $(this).data('job');
            $('#editJobForm').attr('action', "{{ route('managed-jobs.update', ':id') }}".replace(':id', j.id));
            const html = document.getElementById('jobFieldsTemplate').innerHTML;
            $('#editJobModalBody').html(html);

            // Init Select2 + autofill in edit modal body
            initPropAutofill('#editJobModal');

            const $b = $('#editJobModalBody');
            $b.find('[name="property_id"]').val(j.property_id).trigger('change');
            $b.find('[name="scheduled_at"]').val(j.scheduled_at ? j.scheduled_at.substring(0,16) : '');
            $b.find('[name="status"]').val(j.status);
            $b.find('[name="job_details"]').val(j.job_details);
            $b.find('[name="who_attended"]').val(j.who_attended);
            $b.find('[name="tools_needed"]').val(j.tools_needed);
            $b.find('[name="materials_needed"]').val(j.materials_needed);
            $b.find('[name="agreed_price"]').val(j.agreed_price);
            $b.find('[name="vat"]').val(j.vat);
            $b.find('[name="total_price"]').val(j.total_price);
            $b.find('[name="cash_payment_received"]').val(j.cash_payment_received);
            $b.find('[name="acc_payment_received"]').val(j.acc_payment_received);
        });
    });

    function calcTotal(scope) {
        const s = scope ? $(scope) : $('body');
        const agreed = parseFloat(s.find('[name="agreed_price"]').val()) || 0;
        const vat    = parseFloat(s.find('[name="vat"]').val()) || 0;
        s.find('[name="total_price"]').val((agreed + vat).toFixed(2));
    }
    </script>
    @endpush
</x-backend-layout>
