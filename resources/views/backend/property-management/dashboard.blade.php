<x-backend.layouts.master title="Property Management Dashboard">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2 mb-4">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-0">Property Management Dashboard</h1>
            <ol class="breadcrumb mb-0 ms-1">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Property Management</li>
            </ol>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-sm-6 mb-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Properties</p>
                            <h4 class="mb-0">{{ $stats['total_properties'] }}</h4>
                        </div>
                        <i class="ri-building-2-line fs-24 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 mb-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Managed Jobs</p>
                            <h4 class="mb-0">{{ $stats['total_jobs'] }}</h4>
                        </div>
                        <i class="ri-task-line fs-24 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 mb-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Team Logs</p>
                            <h4 class="mb-0">{{ $stats['total_logs'] }}</h4>
                        </div>
                        <i class="ri-team-line fs-24 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 mb-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Daily Finances</p>
                            <h4 class="mb-0">{{ $stats['total_finances'] }}</h4>
                        </div>
                        <i class="ri-money-pound-circle-line fs-24 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 mb-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1">To-Do Lists</p>
                            <h4 class="mb-0">{{ $stats['total_todos'] }}</h4>
                        </div>
                        <i class="ri-checkbox-multiple-line fs-24 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="card custom-card">
        <ul class="nav nav-tabs nav-justified mb-0" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="#properties-tab" class="nav-link active" data-bs-toggle="tab" role="tab" aria-selected="true">
                    <i class="ri-building-2-line me-2"></i>Properties
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#jobs-tab" class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false">
                    <i class="ri-task-line me-2"></i>Managed Jobs
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#logs-tab" class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false">
                    <i class="ri-team-line me-2"></i>Team Logs
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#finances-tab" class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false">
                    <i class="ri-money-pound-circle-line me-2"></i>Daily Finances
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#todos-tab" class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false">
                    <i class="ri-checkbox-multiple-line me-2"></i>To-Do Lists
                </a>
            </li>
        </ul>

        <div class="tab-content p-4">
            <!-- Properties Tab -->
            <div class="tab-pane fade show active" id="properties-tab" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">All Properties ({{ $properties->total() }})</h5>
                    <button type="button" class="btn btn-primary btn-sm btn-wave" onclick="openPropertyModal()">
                        <i class="ri-add-line me-1"></i> Add Property
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap mb-0 fs-13">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Address</th>
                                <th>Client</th>
                                <th>Tenant</th>
                                <th>Gas Cert</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($properties as $i => $property)
                            <tr>
                                <td>{{ $properties->firstItem() + $i }}</td>
                                <td style="max-width:150px;white-space:normal">{{ $property->address }}</td>
                                <td>{{ $property->client_name ?? '—' }}</td>
                                <td>{{ $property->tenant_name ?? '—' }}</td>
                                <td>
                                    @if($property->gas_cert_expiry)
                                        <span class="badge {{ \Carbon\Carbon::parse($property->gas_cert_expiry)->isPast() ? 'bg-danger-transparent' : 'bg-success-transparent' }}">
                                            {{ \Carbon\Carbon::parse($property->gas_cert_expiry)->format('d M Y') }}
                                        </span>
                                    @else <span class="text-muted">—</span> @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning-transparent" onclick="openPropertyModal({{ $property->id }})" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('properties-management.destroy', $property) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this property?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-transparent" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No properties found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($properties->hasPages())
                    <div class="mt-3">{{ $properties->links('backend.pagination.custom') }}</div>
                @endif
            </div>

            <!-- Managed Jobs Tab -->
            <div class="tab-pane fade" id="jobs-tab" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">All Managed Jobs ({{ $managedJobs->total() }}) <span class="badge bg-danger ms-2">{{ $stats['pending_jobs'] }} Pending</span></h5>
                    <button type="button" class="btn btn-success btn-sm btn-wave" onclick="openJobModal()">
                        <i class="ri-add-line me-1"></i> Add Job
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap mb-0 fs-13">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Property</th>
                                <th>Scheduled Date</th>
                                <th>Job Details</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($managedJobs as $i => $job)
                            <tr>
                                <td>{{ $managedJobs->firstItem() + $i }}</td>
                                <td style="max-width:120px;white-space:normal">{{ $job->property->address ?? '—' }}</td>
                                <td>{{ $job->scheduled_at ? $job->scheduled_at->format('d M Y') : '—' }}</td>
                                <td style="max-width:150px;white-space:normal">{{ Str::limit($job->job_details, 50) }}</td>
                                <td class="fw-semibold">${{ number_format($job->total_price ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge {{ $job->status === 'completed' ? 'bg-success-transparent' : ($job->status === 'pending' ? 'bg-warning-transparent' : 'bg-info-transparent') }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning-transparent" onclick="openJobModal({{ $job->id }})" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('managed-jobs.destroy', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this job?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-transparent" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">No managed jobs found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($managedJobs->hasPages())
                    <div class="mt-3">{{ $managedJobs->links('backend.pagination.custom') }}</div>
                @endif
            </div>

            <!-- Team Logs Tab -->
            <div class="tab-pane fade" id="logs-tab" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">All Team Logs ({{ $teamLogs->total() }}) <span class="badge bg-danger ms-2">{{ $stats['unpaid_logs'] }} Unpaid</span></h5>
                    <button type="button" class="btn btn-info btn-sm btn-wave" onclick="openLogModal()">
                        <i class="ri-add-line me-1"></i> Add Log
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap mb-0 fs-13">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member</th>
                                <th>Date</th>
                                <th>Property</th>
                                <th>Shift</th>
                                <th>Daily Pay</th>
                                <th>Paid?</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teamLogs as $i => $log)
                            <tr>
                                <td>{{ $teamLogs->firstItem() + $i }}</td>
                                <td class="fw-medium">{{ $log->member_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}</td>
                                <td style="max-width:120px;white-space:normal">{{ $log->property->address ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ $log->shift_type === 'Full' ? 'bg-primary-transparent' : 'bg-warning-transparent' }}">
                                        {{ $log->shift_type }}
                                    </span>
                                </td>
                                <td class="fw-semibold">${{ number_format($log->daily_pay, 2) }}</td>
                                <td>
                                    <span class="badge {{ $log->is_paid ? 'bg-success-transparent' : 'bg-danger-transparent' }}">
                                        {{ $log->is_paid ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning-transparent" onclick="openLogModal({{ $log->id }})" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('team-logs.destroy', $log) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this log?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-transparent" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-4 text-muted">No team logs found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($teamLogs->hasPages())
                    <div class="mt-3">{{ $teamLogs->links('backend.pagination.custom') }}</div>
                @endif
            </div>

            <!-- Daily Finances Tab -->
            <div class="tab-pane fade" id="finances-tab" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">All Daily Finances ({{ $dailyFinances->total() }})</h5>
                    <button type="button" class="btn btn-warning btn-sm btn-wave" onclick="openFinanceModal()">
                        <i class="ri-add-line me-1"></i> Add Finance
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap mb-0 fs-13">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Property</th>
                                <th>Date</th>
                                <th>Cash Out</th>
                                <th>Cash In</th>
                                <th>Acc Out</th>
                                <th>Acc In</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dailyFinances as $i => $finance)
                            <tr>
                                <td>{{ $dailyFinances->firstItem() + $i }}</td>
                                <td><span class="badge bg-light text-dark">{{ ucfirst($finance->expense_type) }}</span></td>
                                <td style="max-width:120px;white-space:normal">{{ $finance->property->address ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($finance->date)->format('d M Y') }}</td>
                                <td class="text-danger">${{ number_format($finance->cash_out ?? 0, 2) }}</td>
                                <td class="text-success">${{ number_format($finance->cash_in ?? 0, 2) }}</td>
                                <td class="text-danger">${{ number_format($finance->acc_out ?? 0, 2) }}</td>
                                <td class="text-success">${{ number_format($finance->acc_in ?? 0, 2) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning-transparent" onclick="openFinanceModal({{ $finance->id }})" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('daily-finances.destroy', $finance) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this finance record?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-transparent" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="text-center py-4 text-muted">No daily finances found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($dailyFinances->hasPages())
                    <div class="mt-3">{{ $dailyFinances->links('backend.pagination.custom') }}</div>
                @endif
            </div>

            <!-- To-Do Lists Tab -->
            <div class="tab-pane fade" id="todos-tab" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">All To-Do Lists ({{ $todoLists->total() }})</h5>
                    <button type="button" class="btn btn-danger btn-sm btn-wave" onclick="openTodoModal()">
                        <i class="ri-add-line me-1"></i> Add To-Do
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap mb-0 fs-13">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todoLists as $i => $todo)
                            <tr>
                                <td>{{ $todoLists->firstItem() + $i }}</td>
                                <td class="fw-medium">{{ $todo->title }}</td>
                                <td style="max-width:150px;white-space:normal">{{ Str::limit($todo->description ?? '', 50) }}</td>
                                <td>
                                    <span class="badge {{ $todo->priority === 'high' ? 'bg-danger-transparent' : ($todo->priority === 'medium' ? 'bg-warning-transparent' : 'bg-info-transparent') }}">
                                        {{ ucfirst($todo->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $todo->status === 'completed' ? 'bg-success-transparent' : 'bg-warning-transparent' }}">
                                        {{ ucfirst($todo->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($todo->due_date)
                                        <span class="badge {{ \Carbon\Carbon::parse($todo->due_date)->isPast() && $todo->status !== 'completed' ? 'bg-danger-transparent' : 'bg-light text-dark' }}">
                                            {{ \Carbon\Carbon::parse($todo->due_date)->format('d M Y') }}
                                        </span>
                                    @else <span class="text-muted">—</span> @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning-transparent" onclick="openTodoModal({{ $todo->id }})" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('todo-list.destroy', $todo) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this to-do?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-transparent" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">No to-do lists found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($todoLists->hasPages())
                    <div class="mt-3">{{ $todoLists->links('backend.pagination.custom') }}</div>
                @endif
            </div>
        </div>
    </div>
</x-backend.layouts.master>

@include('backend.property-management.modals')
