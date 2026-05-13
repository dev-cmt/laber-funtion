<x-backend-layout title="Team Logs">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between my-4 flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-bold fs-18 mb-1">
                <i class="ri-team-line me-2 text-primary"></i>Team Attendance & Payouts
            </h1>
            <ol class="breadcrumb mb-0 fs-12">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Team Logs</li>
            </ol>
        </div>
        <button type="button" class="btn btn-primary btn-wave waves-light fw-semibold px-4"
            data-bs-toggle="modal" data-bs-target="#createLogModal">
            <i class="ri-user-add-fill me-2 align-middle"></i> Add Work Log
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="ri-checkbox-circle-line me-2 fs-16"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Summary Stats --}}
    <div class="row g-3 mb-4">
        @php
            $totalLogs  = $logs->total();
            $paidLogs   = \App\Models\TeamLog::where('is_paid', true)->count();
            $unpaidLogs = \App\Models\TeamLog::where('is_paid', false)->count();
            $totalPay   = \App\Models\TeamLog::sum('daily_pay');
        @endphp
        @foreach([
            ['label'=>'Total Logs',  'val'=>$totalLogs,            'color'=>'primary', 'icon'=>'ri-file-list-3-line', 'prefix'=>''],
            ['label'=>'Paid',        'val'=>$paidLogs,             'color'=>'success', 'icon'=>'ri-checkbox-circle-line', 'prefix'=>''],
            ['label'=>'Unpaid',      'val'=>$unpaidLogs,           'color'=>'danger',  'icon'=>'ri-error-warning-line', 'prefix'=>''],
            ['label'=>'Total Payout','val'=>number_format($totalPay,2), 'color'=>'warning','icon'=>'ri-money-pound-box-line','prefix'=>'$'],
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
                            <h4 class="fw-bold mb-0 text-{{ $stat['color'] }}">{{ $stat['prefix'] }}{{ $stat['val'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Logs Table --}}
    <div class="card custom-card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-15 fw-bold text-dark">Attendance Log</span>
                    <span class="badge bg-primary rounded-pill">{{ $logs->total() }}</span>
                </div>
                <select class="form-select form-select-sm border-0 bg-light" id="payFilter" style="width:150px">
                    <option value="">All Entries</option>
                    <option value="paid">Paid Only</option>
                    <option value="unpaid">Unpaid Only</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8f9fc;">
                        <tr class="text-muted fs-12 fw-semibold text-uppercase">
                            <th class="ps-4 py-3" style="width:50px">#</th>
                            <th class="py-3">Staff Member</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Property / Site</th>
                            <th class="py-3">Shift</th>
                            <th class="py-3 text-end">Daily Pay</th>
                            <th class="py-3 text-center">Payment</th>
                            <th class="pe-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $i => $log)
                        <tr class="log-row" data-paid="{{ $log->is_paid ? 'paid' : 'unpaid' }}">
                            <td class="ps-4 text-muted fs-12 fw-medium">{{ $logs->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle fw-bold"
                                        style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;font-size:13px">
                                        {{ strtoupper(substr($log->member_name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold fs-13">{{ $log->member_name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="fs-12 text-muted">
                                    <i class="ri-calendar-line me-1 text-primary"></i>{{ \Carbon\Carbon::parse($log->date)->format('d M, Y') }}
                                </span>
                            </td>
                            <td>
                                <div class="fs-12 text-muted" style="max-width:180px;white-space:normal">
                                    <i class="ri-map-pin-line me-1 text-danger"></i>{{ Str::limit($log->property->address ?? '—', 40) }}
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $log->shift_type === 'Full' ? 'bg-info' : 'bg-warning' }}-transparent rounded-pill fs-11 px-3">
                                    {{ $log->shift_type }} Day
                                </span>
                            </td>
                            <td class="text-end">
                                <span class="fw-bold text-dark fs-13">${{ number_format($log->daily_pay, 2) }}</span>
                            </td>
                            <td class="text-center">
                                @if($log->is_paid)
                                <span class="badge bg-success-transparent text-success rounded-pill fs-11 px-3">
                                    <i class="ri-checkbox-circle-line me-1"></i>Paid
                                </span>
                                @else
                                <span class="badge bg-danger-transparent text-danger rounded-pill fs-11 px-3">
                                    <i class="ri-error-warning-line me-1"></i>Pending
                                </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-sm btn-icon btn-warning-transparent rounded-circle edit-log-btn"
                                        data-bs-toggle="modal" data-bs-target="#editLogModal"
                                        data-log="{{ json_encode($log) }}" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('team-logs.destroy', $log) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this log?')">
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
                            <td colspan="8" class="text-center py-5">
                                <div class="py-4">
                                    <i class="ri-team-line fs-48 text-muted opacity-50 d-block mb-3"></i>
                                    <p class="text-muted fs-14 mb-1 fw-medium">No Attendance Logs</p>
                                    <p class="text-muted fs-12 mb-3">Start logging staff attendance and payouts.</p>
                                    <button class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#createLogModal">
                                        <i class="ri-add-line me-1"></i> Add Log
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $logs->links('backend.pagination.custom') }}
        </div>
        @endif
    </div>

    {{-- CREATE MODAL --}}
    <div class="modal fade" id="createLogModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('team-logs.store') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white py-3 px-4" style="background:linear-gradient(135deg,#10b981,#3b82f6)">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-user-add-fill fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Add Attendance Log</h5>
                                <p class="mb-0 fs-11 opacity-75">Record a staff work day and payout</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" style="max-height:70vh;overflow-y:auto;background:#f8f9fc">
                        @include('backend.property-management.team-logs._modal_fields', ['log' => null, 'properties' => $properties])
                    </div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background:linear-gradient(135deg,#10b981,#3b82f6);border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Save Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editLogModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form id="editLogForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header text-white py-3 px-4" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-edit-box-fill fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Update Work Log</h5>
                                <p class="mb-0 fs-11 opacity-75">Edit attendance record details</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" id="editLogModalBody" style="max-height:70vh;overflow-y:auto;background:#f8f9fc"></div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background:linear-gradient(135deg,#f59e0b,#ef4444);border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Update Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="logFieldsTemplate">
        @include('backend.property-management.team-logs._modal_fields', ['log' => null, 'properties' => $properties, 'isTemplate' => true])
    </template>

    @push('js')
    <script>
    function initPropAutofill(modalSelector) {
        const $modal = $(modalSelector);
        $modal.find('.prop-autofill-select').each(function () {
            if ($(this).data('select2')) return;
            $(this).select2({
                dropdownParent: $modal,
                placeholder: $(this).data('placeholder') || '— Select Property —',
                allowClear: true,
                width: '100%',
            });
        });
        $modal.on('change', '.prop-autofill-select', function () {
            const $opt  = $(this).find('option:selected');
            const val   = $(this).val();
            const $card = $(this).closest('.row').find('.prop-info-card');
            if (!val) { $card.hide(); return; }
            $card.find('.prop-info-address').text($opt.data('address')  || '—');
            $card.find('.prop-info-client').text($opt.data('client')    || '—');
            $card.find('.prop-info-phone').text($opt.data('phone')      || '—');
            $card.find('.prop-info-tenant').text($opt.data('tenant')    || '—');
            $card.show();
        });
        $modal.find('.prop-autofill-select').each(function () {
            if ($(this).val()) $(this).trigger('change');
        });
    }

    $(document).ready(function () {
        // Payment filter
        $('#payFilter').on('change', function () {
            const val = $(this).val();
            $('.log-row').each(function () {
                $(this).toggle(!val || $(this).data('paid') === val);
            });
        });

        // Init Select2 for create modal
        $('#createLogModal').on('shown.bs.modal', function () {
            initPropAutofill('#createLogModal');
        });

        // Edit modal
        $('.edit-log-btn').on('click', function () {
            const l = $(this).data('log');
            $('#editLogForm').attr('action', "{{ route('team-logs.update', ':id') }}".replace(':id', l.id));
            const html = document.getElementById('logFieldsTemplate').innerHTML;
            $('#editLogModalBody').html(html);

            initPropAutofill('#editLogModal');

            const $b = $('#editLogModalBody');
            $b.find('[name="member_name"]').val(l.member_name);
            $b.find('[name="date"]').val(l.date);
            $b.find('[name="site_id"]').val(l.site_id).trigger('change');
            $b.find('[name="shift_type"]').val(l.shift_type);
            $b.find('[name="daily_pay"]').val(l.daily_pay);
            if (l.is_paid) $b.find('[name="is_paid"]').prop('checked', true);
        });
    });
    </script>
    @endpush
</x-backend-layout>
