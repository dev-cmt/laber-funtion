<x-backend-layout title="Units Management">

    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Units Management</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Units</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Units List</div>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUnitModal">
                        <i class="ri-add-line me-1 fw-semibold align-middle"></i>Add New Unit
                    </button>
                </div>

                <div class="card-body">

                    {{-- Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Success --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Unit Name</th>
                                    <th>Short Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($units as $key => $unit)
                                    <tr>
                                        <td>{{ $units->firstItem() + $key }}</td>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $unit->short_name }}</td>
                                        <td class="text-capitalize">{{ $unit->unit_type }}</td>
                                        <td>
                                            <span class="badge bg-{{ $unit->status ? 'success' : 'danger' }}-transparent">
                                                {{ $unit->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <button type="button"
                                                    class="btn btn-sm btn-warning-light btn-icon edit-unit"
                                                    data-id="{{ $unit->id }}"
                                                    data-name="{{ $unit->name }}"
                                                    data-short_name="{{ $unit->short_name }}"
                                                    data-unit_type="{{ $unit->unit_type }}"
                                                    data-status="{{ $unit->status }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editUnitModal">
                                                    <i class="ri-pencil-line"></i>
                                                </button>

                                                <form action="{{ route('units.destroy', $unit->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger-light btn-icon"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No units found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $units->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Unit Modal -->
    <div class="modal fade" id="createUnitModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('units.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title">Create New Unit</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Unit Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Name</label>
                            <input type="text" class="form-control" name="short_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Unit Type</label>
                            <select class="form-select" name="unit_type" required>
                                <option value="quantity">Quantity</option>
                                <option value="weight">Weight</option>
                                <option value="volume">Volume</option>
                                <option value="length">Length</option>
                            </select>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Unit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Unit Modal -->
    <div class="modal fade" id="editUnitModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('units.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-header">
                        <h6 class="modal-title">Edit Unit</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Unit Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Name</label>
                            <input type="text" class="form-control" id="edit_short_name" name="short_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Unit Type</label>
                            <select class="form-select" id="edit_unit_type" name="unit_type">
                                <option value="quantity">Quantity</option>
                                <option value="weight">Weight</option>
                                <option value="volume">Volume</option>
                                <option value="length">Length</option>
                            </select>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Unit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        $(document).on('click', '.edit-unit', function () {
            $('#edit_id').val($(this).data('id'));
            $('#edit_name').val($(this).data('name'));
            $('#edit_short_name').val($(this).data('short_name'));
            $('#edit_unit_type').val($(this).data('unit_type'));
            $('#edit_status').val($(this).data('status'));
        });

        $('#createUnitModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        });
    </script>
    @endpush

</x-backend-layout>
