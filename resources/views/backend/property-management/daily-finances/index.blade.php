<x-backend-layout title="Daily Finances">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between my-4 flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-bold fs-18 mb-1">
                <i class="ri-money-pound-circle-line me-2 text-primary"></i>Financial Ledger
            </h1>
            <ol class="breadcrumb mb-0 fs-12">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Daily Finances</li>
            </ol>
        </div>
        <button type="button" class="btn btn-primary btn-wave waves-light fw-semibold px-4"
            data-bs-toggle="modal" data-bs-target="#createFinanceModal">
            <i class="ri-add-circle-fill me-2 align-middle"></i> Add Record
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="ri-checkbox-circle-line me-2 fs-16"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        @php
            $allFinances = \App\Models\DailyFinance::all();
            $cashIn   = $allFinances->sum('cash_in');
            $cashOut  = $allFinances->sum('cash_out');
            $accIn    = $allFinances->sum('acc_in');
            $accOut   = $allFinances->sum('acc_out');
            $netCash  = $cashIn - $cashOut;
            $netAcc   = $accIn - $accOut;
        @endphp
        @foreach([
            ['label'=>'Cash In',    'val'=>$cashIn,  'color'=>'success', 'icon'=>'ri-arrow-left-down-line',  'prefix'=>'$'],
            ['label'=>'Cash Out',   'val'=>$cashOut, 'color'=>'danger',  'icon'=>'ri-arrow-right-up-line',   'prefix'=>'$'],
            ['label'=>'Account In', 'val'=>$accIn,   'color'=>'info',    'icon'=>'ri-bank-line',             'prefix'=>'$'],
            ['label'=>'Account Out','val'=>$accOut,  'color'=>'warning', 'icon'=>'ri-bank-card-line',        'prefix'=>'$'],
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
                            <h4 class="fw-bold mb-0 text-{{ $stat['color'] }}">{{ $stat['prefix'] }}{{ number_format($stat['val'], 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Net Balance Row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card custom-card border-0 shadow-sm rounded-4 mb-0"
                style="background: linear-gradient(135deg, {{ $netCash >= 0 ? '#10b981,#059669' : '#ef4444,#dc2626' }});">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-25 rounded-3 p-2 d-flex">
                        <i class="ri-cash-line fs-24 text-white"></i>
                    </div>
                    <div>
                        <p class="text-white opacity-75 fs-11 fw-semibold text-uppercase mb-0">Net Cash Balance</p>
                        <h3 class="text-white fw-bold mb-0">${{ number_format($netCash, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card custom-card border-0 shadow-sm rounded-4 mb-0"
                style="background: linear-gradient(135deg, {{ $netAcc >= 0 ? '#3b82f6,#6366f1' : '#ef4444,#dc2626' }});">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-25 rounded-3 p-2 d-flex">
                        <i class="ri-bank-line fs-24 text-white"></i>
                    </div>
                    <div>
                        <p class="text-white opacity-75 fs-11 fw-semibold text-uppercase mb-0">Net Account Balance</p>
                        <h3 class="text-white fw-bold mb-0">${{ number_format($netAcc, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Finance Table --}}
    <div class="card custom-card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-15 fw-bold text-dark">Transaction History</span>
                    <span class="badge bg-primary rounded-pill">{{ $finances->total() }}</span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8f9fc;">
                        <tr class="text-muted fs-12 fw-semibold text-uppercase">
                            <th class="ps-4 py-3" style="width:50px">#</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Site / Property</th>
                            <th class="py-3 text-end text-success">Cash In</th>
                            <th class="py-3 text-end text-danger">Cash Out</th>
                            <th class="py-3 text-end text-info">Acc In</th>
                            <th class="py-3 text-end text-warning">Acc Out</th>
                            <th class="pe-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($finances as $i => $fin)
                        <tr>
                            <td class="ps-4 text-muted fs-12 fw-medium">{{ $finances->firstItem() + $i }}</td>
                            <td>
                                <span class="fs-12 fw-medium">
                                    <i class="ri-calendar-event-line me-1 text-primary"></i>{{ \Carbon\Carbon::parse($fin->date)->format('d M, Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info-transparent rounded-pill fs-11 px-3">{{ $fin->expense_type }}</span>
                            </td>
                            <td>
                                <div class="fs-12 text-muted" style="max-width:160px;white-space:normal">
                                    <i class="ri-map-pin-line me-1 text-danger"></i>{{ Str::limit($fin->property->address ?? 'General Office', 38) }}
                                </div>
                            </td>
                            <td class="text-end">
                                @if($fin->cash_in > 0)
                                <span class="fw-semibold text-success fs-12">${{ number_format($fin->cash_in, 2) }}</span>
                                @else<span class="text-muted fs-12">—</span>@endif
                            </td>
                            <td class="text-end">
                                @if($fin->cash_out > 0)
                                <span class="fw-semibold text-danger fs-12">${{ number_format($fin->cash_out, 2) }}</span>
                                @else<span class="text-muted fs-12">—</span>@endif
                            </td>
                            <td class="text-end">
                                @if($fin->acc_in > 0)
                                <span class="fw-semibold text-info fs-12">${{ number_format($fin->acc_in, 2) }}</span>
                                @else<span class="text-muted fs-12">—</span>@endif
                            </td>
                            <td class="text-end">
                                @if($fin->acc_out > 0)
                                <span class="fw-semibold text-warning fs-12">${{ number_format($fin->acc_out, 2) }}</span>
                                @else<span class="text-muted fs-12">—</span>@endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-sm btn-icon btn-warning-transparent rounded-circle edit-fin-btn"
                                        data-bs-toggle="modal" data-bs-target="#editFinanceModal"
                                        data-fin="{{ json_encode($fin) }}" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('daily-finances.destroy', $fin) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this record?')">
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
                            <td colspan="9" class="text-center py-5">
                                <div class="py-4">
                                    <i class="ri-money-pound-circle-line fs-48 text-muted opacity-50 d-block mb-3"></i>
                                    <p class="text-muted fs-14 mb-1 fw-medium">No Financial Records</p>
                                    <p class="text-muted fs-12 mb-3">Start recording your property finances.</p>
                                    <button class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#createFinanceModal">
                                        <i class="ri-add-line me-1"></i> Add Record
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($finances->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $finances->links('backend.pagination.custom') }}
        </div>
        @endif
    </div>

    {{-- CREATE MODAL --}}
    <div class="modal fade" id="createFinanceModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('daily-finances.store') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white py-3 px-4" style="background:linear-gradient(135deg,#10b981,#3b82f6)">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-receipt-line fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Add Finance Record</h5>
                                <p class="mb-0 fs-11 opacity-75">Record a new cash or account transaction</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" style="max-height:70vh;overflow-y:auto;background:#f8f9fc">
                        @include('backend.property-management.daily-finances._modal_fields', ['fin' => null, 'properties' => $properties])
                    </div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background:linear-gradient(135deg,#10b981,#3b82f6);border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Save Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editFinanceModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form id="editFinanceForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header text-white py-3 px-4" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-edit-box-line fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Update Finance Record</h5>
                                <p class="mb-0 fs-11 opacity-75">Edit and save the transaction details</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" id="editFinanceModalBody" style="max-height:70vh;overflow-y:auto;background:#f8f9fc"></div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background:linear-gradient(135deg,#f59e0b,#ef4444);border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Update Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="finFieldsTemplate">
        @include('backend.property-management.daily-finances._modal_fields', ['fin' => null, 'properties' => $properties, 'isTemplate' => true])
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
            $card.find('.prop-info-address').text($opt.data('address') || '—');
            $card.find('.prop-info-client').text($opt.data('client')   || '—');
            $card.find('.prop-info-phone').text($opt.data('phone')     || '—');
            $card.find('.prop-info-tenant').text($opt.data('tenant')   || '—');
            $card.show();
        });
        $modal.find('.prop-autofill-select').each(function () {
            if ($(this).val()) $(this).trigger('change');
        });
    }

    $(document).ready(function () {
        // Init Select2 for create modal
        $('#createFinanceModal').on('shown.bs.modal', function () {
            initPropAutofill('#createFinanceModal');
        });

        // Edit modal
        $('.edit-fin-btn').on('click', function () {
            const f = $(this).data('fin');
            $('#editFinanceForm').attr('action', "{{ route('daily-finances.update', ':id') }}".replace(':id', f.id));
            const html = document.getElementById('finFieldsTemplate').innerHTML;
            $('#editFinanceModalBody').html(html);

            initPropAutofill('#editFinanceModal');

            const $b = $('#editFinanceModalBody');
            $b.find('[name="expense_type"]').val(f.expense_type);
            $b.find('[name="date"]').val(f.date);
            $b.find('[name="site_id"]').val(f.site_id ?? '').trigger('change');
            ['cash_in','cash_out','cash_refund','acc_in','acc_out','acc_refund'].forEach(field => {
                $b.find(`[name="${field}"]`).val(f[field] ?? '0.00');
            });
        });
    });
    </script>
    @endpush
</x-backend-layout>
