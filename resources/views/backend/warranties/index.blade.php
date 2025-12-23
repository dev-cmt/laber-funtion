<x-backend-layout title="Warranty Management">

    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Warranty Management</h1>
        <div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createWarrantyModal">
                <i class="ri-add-line me-1"></i>Add Warranty
            </button>
        </div>
    </div>

    <div class="card custom-card">
        <div class="card-body">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Warranty Name</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($warranties as $key => $warranty)
                            <tr>
                                <td>{{ $warranties->firstItem() + $key }}</td>
                                <td>{{ $warranty->name }}</td>
                                <td>{{ $warranty->full_duration }}</td>
                                <td>
                                    <span class="badge bg-{{ $warranty->status ? 'success' : 'danger' }}-transparent">
                                        {{ $warranty->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning-light edit-warranty"
                                        data-id="{{ $warranty->id }}"
                                        data-name="{{ $warranty->name }}"
                                        data-duration="{{ $warranty->duration }}"
                                        data-period="{{ $warranty->period }}"
                                        data-description="{{ $warranty->description }}"
                                        data-status="{{ $warranty->status }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editWarrantyModal">
                                        <i class="ri-pencil-line"></i>
                                    </button>

                                    <form action="{{ route('warranties.destroy', $warranty->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger-light"
                                            onclick="return confirm('Delete this warranty?')">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No warranties found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $warranties->links() }}
        </div>
    </div>

    {{-- Create Warranty Modal --}}
    <div class="modal fade" id="createWarrantyModal">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('warranties.store') }}">
                @csrf
                <div class="modal-header">
                    <h6>Create Warranty</h6>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Warranty Name</label>
                        <input class="form-control" name="name" placeholder="Warranty Name" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Duration</label>
                            <input class="form-control" name="duration" type="number" placeholder="Duration" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Period</label>
                            <select class="form-select" name="period">
                                <option value="day">Day</option>
                                <option value="month">Month</option>
                                <option value="year">Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" placeholder="Description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Warranty Modal --}}
    <div class="modal fade" id="editWarrantyModal">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('warranties.update') }}">
                @csrf
                <input type="hidden" name="id" id="edit_id">

                <div class="modal-header">
                    <h6>Edit Warranty</h6>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Warranty Name</label>
                        <input class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Duration</label>
                            <input class="form-control" id="edit_duration" name="duration" type="number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Period</label>
                            <select class="form-select" id="edit_period" name="period">
                                <option value="day">Day</option>
                                <option value="month">Month</option>
                                <option value="year">Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
    <script>
        $('.edit-warranty').on('click', function () {
            $('#edit_id').val($(this).data('id'));
            $('#edit_name').val($(this).data('name'));
            $('#edit_duration').val($(this).data('duration'));
            $('#edit_period').val($(this).data('period'));
            $('#edit_description').val($(this).data('description'));
            $('#edit_status').val($(this).data('status'));
        });
    </script>
    @endpush

</x-backend-layout>
