<x-backend-layout title="Todo / Appointments">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between my-4 flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-bold fs-18 mb-1">
                <i class="ri-task-line me-2 text-primary"></i>Todo & Appointments
            </h1>
            <ol class="breadcrumb mb-0 fs-12">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Todo List</li>
            </ol>
        </div>
        <button type="button" class="btn btn-primary btn-wave waves-light fw-semibold px-4"
            data-bs-toggle="modal" data-bs-target="#createTodoModal">
            <i class="ri-add-circle-fill me-2 align-middle"></i> Add New Task
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
            $allTodos    = \App\Models\TodoList::all();
            $open        = $allTodos->where('status', 'Open')->count();
            $done        = $allTodos->where('status', 'Done')->count();
            $postponed   = $allTodos->where('status', 'Postponed')->count();
            $appointments= $allTodos->where('type', 'Appointment')->count();
        @endphp
        @foreach([
            ['label'=>'Open Tasks',    'val'=>$open,         'color'=>'primary', 'icon'=>'ri-list-check-2'],
            ['label'=>'Completed',     'val'=>$done,         'color'=>'success', 'icon'=>'ri-checkbox-circle-line'],
            ['label'=>'Postponed',     'val'=>$postponed,    'color'=>'warning', 'icon'=>'ri-time-line'],
            ['label'=>'Appointments',  'val'=>$appointments, 'color'=>'info',    'icon'=>'ri-calendar-event-line'],
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

    {{-- Todo Table --}}
    <div class="card custom-card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-15 fw-bold text-dark">Upcoming Tasks</span>
                    <span class="badge bg-primary rounded-pill">{{ $todos->total() }}</span>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <select class="form-select form-select-sm border-0 bg-light" id="typeFilter" style="width:130px">
                        <option value="">All Types</option>
                        <option value="To-Do">To-Do</option>
                        <option value="Appointment">Appointment</option>
                    </select>
                    <select class="form-select form-select-sm border-0 bg-light" id="statusTodoFilter" style="width:130px">
                        <option value="">All Status</option>
                        <option value="Open">Open</option>
                        <option value="Done">Done</option>
                        <option value="Postponed">Postponed</option>
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
                            <th class="py-3">Type</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Due Date</th>
                            <th class="py-3">Location</th>
                            <th class="py-3">Details</th>
                            <th class="pe-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todos as $i => $todo)
                        @php
                            $isOverdue = $todo->due_date && \Carbon\Carbon::parse($todo->due_date)->isPast() && $todo->status !== 'Done';
                            $statusMap = [
                                'Done'      => ['bg-success','ri-checkbox-circle-line'],
                                'Open'      => ['bg-primary','ri-list-check-2'],
                                'Postponed' => ['bg-warning','ri-time-line'],
                            ];
                            [$sBadge, $sIcon] = $statusMap[$todo->status] ?? ['bg-secondary','ri-question-line'];
                        @endphp
                        <tr class="todo-row" data-type="{{ $todo->type }}" data-status="{{ $todo->status }}">
                            <td class="ps-4 text-muted fs-12 fw-medium">{{ $todos->firstItem() + $i }}</td>
                            <td>
                                <span class="badge {{ $todo->type === 'Appointment' ? 'bg-info' : 'bg-secondary' }}-transparent rounded-pill fs-11 px-3">
                                    <i class="{{ $todo->type === 'Appointment' ? 'ri-calendar-event-line' : 'ri-list-check-2' }} me-1"></i>{{ $todo->type }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $sBadge }}-transparent rounded-pill fs-11 px-3">
                                    <i class="{{ $sIcon }} me-1"></i>{{ $todo->status }}
                                </span>
                            </td>
                            <td>
                                <span class="fs-12 {{ $isOverdue ? 'text-danger fw-semibold' : 'text-muted' }}">
                                    <i class="ri-{{ $isOverdue ? 'alarm-warning' : 'time' }}-line me-1"></i>
                                    {{ $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('d M Y, H:i') : '—' }}
                                </span>
                                @if($isOverdue)
                                <span class="badge bg-danger-transparent text-danger fs-10 ms-1 rounded-pill">Overdue</span>
                                @endif
                            </td>
                            <td>
                                <span class="fs-12 text-muted">
                                    <i class="ri-map-pin-line me-1 text-danger"></i>{{ $todo->location ?: 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div class="text-muted fs-12" style="max-width:220px;white-space:normal"
                                    title="{{ $todo->details }}">
                                    {{ Str::limit($todo->details, 55) }}
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-sm btn-icon btn-warning-transparent rounded-circle edit-todo-btn"
                                        data-bs-toggle="modal" data-bs-target="#editTodoModal"
                                        data-todo="{{ json_encode($todo) }}" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </button>
                                    <form action="{{ route('todo-list.destroy', $todo) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this task?')">
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
                                    <i class="ri-task-line fs-48 text-muted opacity-50 d-block mb-3"></i>
                                    <p class="text-muted fs-14 mb-1 fw-medium">No Tasks or Appointments</p>
                                    <p class="text-muted fs-12 mb-3">Organize your schedule by adding your first task.</p>
                                    <button class="btn btn-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#createTodoModal">
                                        <i class="ri-add-line me-1"></i> Add Task
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($todos->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $todos->links('backend.pagination.custom') }}
        </div>
        @endif
    </div>

    {{-- CREATE MODAL --}}
    <div class="modal fade" id="createTodoModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('todo-list.store') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white py-3 px-4" style="background:linear-gradient(135deg,#8b5cf6,#6366f1)">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-add-box-line fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">New Task / Appointment</h5>
                                <p class="mb-0 fs-11 opacity-75">Add a new task or schedule an appointment</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" style="max-height:70vh;overflow-y:auto;background:#f8f9fc">
                        @include('backend.property-management.todo-list._modal_fields', ['todo' => null])
                    </div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background:linear-gradient(135deg,#8b5cf6,#6366f1);border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Save Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editTodoModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form id="editTodoForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header text-white py-3 px-4" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.25)">
                                <i class="ri-edit-box-line fs-20 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Update Task Details</h5>
                                <p class="mb-0 fs-11 opacity-75">Modify and save updated task info</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-sm-4 p-3" id="editTodoModalBody" style="max-height:70vh;overflow-y:auto;background:#f8f9fc"></div>
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light border fw-medium px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn fw-bold px-5 text-white"
                            style="background:linear-gradient(135deg,#f59e0b,#ef4444);border:none">
                            <i class="ri-save-line me-2 align-middle"></i> Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="todoFieldsTemplate">
        @include('backend.property-management.todo-list._modal_fields', ['todo' => null, 'isTemplate' => true])
    </template>

    @push('js')
    <script>
    $(document).ready(function () {
        // Filters
        function applyFilters() {
            const type   = $('#typeFilter').val().toLowerCase();
            const status = $('#statusTodoFilter').val().toLowerCase();
            $('.todo-row').each(function () {
                const matchType   = !type   || $(this).data('type').toLowerCase()   === type;
                const matchStatus = !status || $(this).data('status').toLowerCase() === status;
                $(this).toggle(matchType && matchStatus);
            });
        }
        $('#typeFilter, #statusTodoFilter').on('change', applyFilters);

        // Edit modal
        $('.edit-todo-btn').on('click', function () {
            const t = $(this).data('todo');
            $('#editTodoForm').attr('action', "{{ route('todo-list.update', ':id') }}".replace(':id', t.id));
            const html = document.getElementById('todoFieldsTemplate').innerHTML;
            $('#editTodoModalBody').html(html);
            const $b = $('#editTodoModalBody');
            $b.find('[name="type"]').val(t.type);
            $b.find('[name="status"]').val(t.status);
            $b.find('[name="location"]').val(t.location);
            $b.find('[name="details"]').val(t.details);
            if (t.due_date) $b.find('[name="due_date"]').val(t.due_date.replace(' ','T').substring(0,16));
        });
    });
    </script>
    @endpush
</x-backend-layout>
