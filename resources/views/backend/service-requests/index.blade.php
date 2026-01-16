<x-backend-layout title="Service Requests">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Service Requests</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Service Requests</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Service Requests List</div>
                    {{-- @can('create service requests') --}}
                    <a href="{{ route('service-requests.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-line me-1 fw-semibold align-middle"></i>New Request
                    </a>
                    {{-- @endcan --}}
                </div>
                <div class="card-body">

                    {{-- Filters --}}
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="requested">Requested</option>
                                <option value="assigned">Assigned</option>
                                <option value="inspected">Inspected</option>
                                <option value="approved">Approved</option>
                                <option value="completed">Completed</option>
                                <option value="rejected">Rejected</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date From</label>
                            <input type="date" class="form-control" id="dateFrom">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date To</label>
                            <input type="date" class="form-control" id="dateTo">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-secondary" id="filterBtn">Filter</button>
                            <button type="button" class="btn btn-light ms-2" id="resetFilter">Reset</button>
                        </div>
                    </div>

                    {{-- Success/Error Alerts --}}
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

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap" id="serviceRequestsTable">
                            <thead>
                                <tr>
                                    <th>SR No</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Assigned To</th>
                                    <th>Visit Date</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $key => $request)
                                    <tr>
                                        <td>SR-{{ str_pad($request->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $request->customer_name }}</td>
                                        <td>{{ $request->customer_phone }}</td>
                                        <td>
                                            @if($request->assignedEmployee)
                                                {{ $request->assignedEmployee->name }}
                                            @else
                                                <span class="text-muted">Not Assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->visit_date)
                                                {{ date('d M, Y', strtotime($request->visit_date)) }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'requested' => 'warning',
                                                    'assigned' => 'info',
                                                    'inspected' => 'primary',
                                                    'approved' => 'success',
                                                    'completed' => 'dark',
                                                    'rejected' => 'danger',
                                                    'cancelled' => 'secondary',
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$request->status] }}-transparent">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $request->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            <div class="btn-list">
                                                <a href="{{ route('service-requests.show', $request) }}" 
                                                   class="btn btn-sm btn-info-light btn-icon"
                                                   title="View Details">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                
                                                @if($request->status == 'requested')
                                                    {{-- @can('edit service requests') --}}
                                                    <a href="{{ route('service-requests.edit', $request) }}" 
                                                       class="btn btn-sm btn-warning-light btn-icon"
                                                       title="Edit">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                    {{-- @endcan --}}
                                                    
                                                    {{-- @can('delete service requests') --}}
                                                    <form action="{{ route('service-requests.destroy', $request) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this request?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger-light btn-icon" title="Delete">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </form>
                                                    {{-- @endcan --}}
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No service requests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        $(document).ready(function() {
            // Filter functionality
            $('#filterBtn').click(function() {
                let status = $('#statusFilter').val();
                let dateFrom = $('#dateFrom').val();
                let dateTo = $('#dateTo').val();
                
                let url = new URL(window.location.href);
                let params = new URLSearchParams(url.search);
                
                if (status) params.set('status', status);
                if (dateFrom) params.set('date_from', dateFrom);
                if (dateTo) params.set('date_to', dateTo);
                
                window.location.href = url.pathname + '?' + params.toString();
            });
            
            $('#resetFilter').click(function() {
                window.location.href = window.location.pathname;
            });
            
            // Preserve filter values on page load
            let urlParams = new URLSearchParams(window.location.search);
            $('#statusFilter').val(urlParams.get('status') || '');
            $('#dateFrom').val(urlParams.get('date_from') || '');
            $('#dateTo').val(urlParams.get('date_to') || '');
        });
    </script>
    @endpush
</x-backend-layout>