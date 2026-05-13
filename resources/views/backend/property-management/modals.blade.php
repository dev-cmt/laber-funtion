<!-- Create/Edit Modals for Dashboard -->

<!-- Property Modal (Create/Edit) -->
<div class="modal fade" id="propertyModal" tabindex="-1" aria-labelledby="propertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="propertyModalLabel">
                    <i class="ri-building-2-line me-2 text-primary"></i><span id="propertyModalTitle">Add Property</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="propertyForm" method="POST">
                @csrf
                <input type="hidden" id="propertyMethod" name="_method" value="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="property_address" class="form-label">Address *</label>
                            <textarea class="form-control" id="property_address" name="address" rows="2" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="property_client_name" class="form-label">Client Name</label>
                            <input type="text" class="form-control" id="property_client_name" name="client_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="property_client_email" class="form-label">Client Email</label>
                            <input type="email" class="form-control" id="property_client_email" name="client_email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="property_tenant_name" class="form-label">Tenant Name</label>
                            <input type="text" class="form-control" id="property_tenant_name" name="tenant_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="property_landlord_name" class="form-label">Landlord Name</label>
                            <input type="text" class="form-control" id="property_landlord_name" name="landlord_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="property_landlord_email" class="form-label">Landlord Email</label>
                            <input type="email" class="form-control" id="property_landlord_email" name="landlord_email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="propertySubmitBtn">
                        <i class="ri-add-line me-1"></i><span id="propertySubmitText">Add Property</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Managed Job Modal (Create/Edit) -->
<div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="jobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobModalLabel">
                    <i class="ri-task-line me-2 text-success"></i><span id="jobModalTitle">Add Managed Job</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="jobForm" method="POST">
                @csrf
                <input type="hidden" id="jobMethod" name="_method" value="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="job_property_id" class="form-label">Property *</label>
                            <select class="form-select" id="job_property_id" name="property_id" required>
                                <option value="">Select Property</option>
                                @foreach($allProperties as $property)
                                    <option value="{{ $property->id }}">{{ $property->address }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="job_scheduled_at" class="form-label">Scheduled Date</label>
                            <input type="datetime-local" class="form-control" id="job_scheduled_at" name="scheduled_at">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="job_status" class="form-label">Status</label>
                            <select class="form-select" id="job_status" name="status">
                                <option value="pending">Pending</option>
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="job_details" class="form-label">Job Details</label>
                            <textarea class="form-control" id="job_details" name="job_details" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="job_agreed_price" class="form-label">Agreed Price ($)</label>
                            <input type="number" class="form-control" id="job_agreed_price" name="agreed_price" step="0.01" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="job_vat" class="form-label">VAT ($)</label>
                            <input type="number" class="form-control" id="job_vat" name="vat" step="0.01" min="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="jobSubmitBtn">
                        <i class="ri-add-line me-1"></i><span id="jobSubmitText">Add Job</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Team Log Modal (Create/Edit) -->
<div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logModalLabel">
                    <i class="ri-team-line me-2 text-info"></i><span id="logModalTitle">Add Team Log</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="logForm" method="POST">
                @csrf
                <input type="hidden" id="logMethod" name="_method" value="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="log_member_name" class="form-label">Member Name *</label>
                            <input type="text" class="form-control" id="log_member_name" name="member_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="log_date" class="form-label">Date *</label>
                            <input type="date" class="form-control" id="log_date" name="date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="log_property_id" class="form-label">Property</label>
                            <select class="form-select" id="log_property_id" name="site_id">
                                <option value="">Select Property</option>
                                @foreach($allProperties as $property)
                                    <option value="{{ $property->id }}">{{ $property->address }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="log_shift_type" class="form-label">Shift Type</label>
                            <select class="form-select" id="log_shift_type" name="shift_type">
                                <option value="Half">Half</option>
                                <option value="Full">Full</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="log_daily_pay" class="form-label">Daily Pay ($)</label>
                            <input type="number" class="form-control" id="log_daily_pay" name="daily_pay" step="0.01" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="log_is_paid" class="form-label">Payment Status</label>
                            <select class="form-select" id="log_is_paid" name="is_paid">
                                <option value="0">Unpaid</option>
                                <option value="1">Paid</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info" id="logSubmitBtn">
                        <i class="ri-add-line me-1"></i><span id="logSubmitText">Add Log</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Daily Finance Modal (Create/Edit) -->
<div class="modal fade" id="financeModal" tabindex="-1" aria-labelledby="financeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="financeModalLabel">
                    <i class="ri-money-pound-circle-line me-2 text-warning"></i><span id="financeModalTitle">Add Daily Finance</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="financeForm" method="POST">
                @csrf
                <input type="hidden" id="financeMethod" name="_method" value="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="finance_expense_type" class="form-label">Expense Type *</label>
                            <select class="form-select" id="finance_expense_type" name="expense_type" required>
                                <option value="">Select Type</option>
                                <option value="material">Material</option>
                                <option value="labour">Labour</option>
                                <option value="transport">Transport</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="finance_property_id" class="form-label">Property</label>
                            <select class="form-select" id="finance_property_id" name="site_id">
                                <option value="">Select Property</option>
                                @foreach($allProperties as $property)
                                    <option value="{{ $property->id }}">{{ $property->address }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="finance_date" class="form-label">Date *</label>
                            <input type="date" class="form-control" id="finance_date" name="date" required>
                        </div>
                        <div class="col-md-6 mb-3"></div>
                        <div class="col-md-6 mb-3">
                            <label for="finance_cash_out" class="form-label">Cash Out ($)</label>
                            <input type="number" class="form-control" id="finance_cash_out" name="cash_out" step="0.01" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="finance_cash_in" class="form-label">Cash In ($)</label>
                            <input type="number" class="form-control" id="finance_cash_in" name="cash_in" step="0.01" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="finance_acc_out" class="form-label">Account Out ($)</label>
                            <input type="number" class="form-control" id="finance_acc_out" name="acc_out" step="0.01" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="finance_acc_in" class="form-label">Account In ($)</label>
                            <input type="number" class="form-control" id="finance_acc_in" name="acc_in" step="0.01" min="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" id="financeSubmitBtn">
                        <i class="ri-add-line me-1"></i><span id="financeSubmitText">Add Finance</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- To-Do Modal (Create/Edit) -->
<div class="modal fade" id="todoModal" tabindex="-1" aria-labelledby="todoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="todoModalLabel">
                    <i class="ri-checkbox-multiple-line me-2 text-danger"></i><span id="todoModalTitle">Add To-Do</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="todoForm" method="POST">
                @csrf
                <input type="hidden" id="todoMethod" name="_method" value="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="todo_title" class="form-label">Title *</label>
                            <input type="text" class="form-control" id="todo_title" name="title" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="todo_description" class="form-label">Description</label>
                            <textarea class="form-control" id="todo_description" name="description" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="todo_priority" class="form-label">Priority</label>
                            <select class="form-select" id="todo_priority" name="priority">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="todo_status" class="form-label">Status</label>
                            <select class="form-select" id="todo_status" name="status">
                                <option value="pending" selected>Pending</option>
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="todo_due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="todo_due_date" name="due_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="todo_type" class="form-label">Type</label>
                            <select class="form-select" id="todo_type" name="type">
                                <option value="Appointment">Appointment</option>
                                <option value="To-Do" selected>To-Do</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="todoSubmitBtn">
                        <i class="ri-add-line me-1"></i><span id="todoSubmitText">Add To-Do</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Property Modal Functions
    window.openPropertyModal = function(propertyId = null) {
        const form = document.getElementById('propertyForm');
        const modal = new bootstrap.Modal(document.getElementById('propertyModal'));
        form.reset();

        if (propertyId) {
            // Edit mode
            document.getElementById('propertyModalTitle').textContent = 'Edit Property';
            document.getElementById('propertySubmitText').textContent = 'Update Property';
            document.getElementById('propertyMethod').value = 'PUT';
            form.action = '{{ route("property-management.dashboard") }}/properties/' + propertyId;

            // Fetch and populate data
            fetch('{{ route("property-management.dashboard") }}/properties/' + propertyId + '/data')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('property_address').value = data.address || '';
                    document.getElementById('property_client_name').value = data.client_name || '';
                    document.getElementById('property_client_email').value = data.client_email || '';
                    document.getElementById('property_tenant_name').value = data.tenant_name || '';
                    document.getElementById('property_landlord_name').value = data.landlord_name || '';
                    document.getElementById('property_landlord_email').value = data.landlord_email || '';
                });
        } else {
            // Create mode
            document.getElementById('propertyModalTitle').textContent = 'Add Property';
            document.getElementById('propertySubmitText').textContent = 'Add Property';
            document.getElementById('propertyMethod').value = 'POST';
            form.action = '{{ route("properties-management.store") }}';
        }
        modal.show();
    };

    // Job Modal Functions
    window.openJobModal = function(jobId = null) {
        const form = document.getElementById('jobForm');
        const modal = new bootstrap.Modal(document.getElementById('jobModal'));
        form.reset();

        if (jobId) {
            document.getElementById('jobModalTitle').textContent = 'Edit Managed Job';
            document.getElementById('jobSubmitText').textContent = 'Update Job';
            document.getElementById('jobMethod').value = 'PUT';
            form.action = '{{ route("property-management.dashboard") }}/jobs/' + jobId;

            fetch('{{ route("property-management.dashboard") }}/jobs/' + jobId + '/data')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('job_property_id').value = data.property_id || '';
                    document.getElementById('job_scheduled_at').value = data.scheduled_at ? data.scheduled_at.slice(0, 16) : '';
                    document.getElementById('job_status').value = data.status || 'pending';
                    document.getElementById('job_details').value = data.job_details || '';
                    document.getElementById('job_agreed_price').value = data.agreed_price || '';
                    document.getElementById('job_vat').value = data.vat || '';
                });
        } else {
            document.getElementById('jobModalTitle').textContent = 'Add Managed Job';
            document.getElementById('jobSubmitText').textContent = 'Add Job';
            document.getElementById('jobMethod').value = 'POST';
            form.action = '{{ route("managed-jobs.store") }}';
        }
        modal.show();
    };

    // Team Log Modal Functions
    window.openLogModal = function(logId = null) {
        const form = document.getElementById('logForm');
        const modal = new bootstrap.Modal(document.getElementById('logModal'));
        form.reset();

        if (logId) {
            document.getElementById('logModalTitle').textContent = 'Edit Team Log';
            document.getElementById('logSubmitText').textContent = 'Update Log';
            document.getElementById('logMethod').value = 'PUT';
            form.action = '{{ route("property-management.dashboard") }}/logs/' + logId;

            fetch('{{ route("property-management.dashboard") }}/logs/' + logId + '/data')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('log_member_name').value = data.member_name || '';
                    document.getElementById('log_date').value = data.date || '';
                    document.getElementById('log_property_id').value = data.site_id || '';
                    document.getElementById('log_shift_type').value = data.shift_type || 'Full';
                    document.getElementById('log_daily_pay').value = data.daily_pay || '';
                    document.getElementById('log_is_paid').value = data.is_paid ? '1' : '0';
                });
        } else {
            document.getElementById('logModalTitle').textContent = 'Add Team Log';
            document.getElementById('logSubmitText').textContent = 'Add Log';
            document.getElementById('logMethod').value = 'POST';
            form.action = '{{ route("team-logs.store") }}';
        }
        modal.show();
    };

    // Finance Modal Functions
    window.openFinanceModal = function(financeId = null) {
        const form = document.getElementById('financeForm');
        const modal = new bootstrap.Modal(document.getElementById('financeModal'));
        form.reset();

        if (financeId) {
            document.getElementById('financeModalTitle').textContent = 'Edit Daily Finance';
            document.getElementById('financeSubmitText').textContent = 'Update Finance';
            document.getElementById('financeMethod').value = 'PUT';
            form.action = '{{ route("property-management.dashboard") }}/finances/' + financeId;

            fetch('{{ route("property-management.dashboard") }}/finances/' + financeId + '/data')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('finance_expense_type').value = data.expense_type || '';
                    document.getElementById('finance_property_id').value = data.site_id || '';
                    document.getElementById('finance_date').value = data.date || '';
                    document.getElementById('finance_cash_out').value = data.cash_out || '';
                    document.getElementById('finance_cash_in').value = data.cash_in || '';
                    document.getElementById('finance_acc_out').value = data.acc_out || '';
                    document.getElementById('finance_acc_in').value = data.acc_in || '';
                });
        } else {
            document.getElementById('financeModalTitle').textContent = 'Add Daily Finance';
            document.getElementById('financeSubmitText').textContent = 'Add Finance';
            document.getElementById('financeMethod').value = 'POST';
            form.action = '{{ route("daily-finances.store") }}';
        }
        modal.show();
    };

    // Todo Modal Functions
    window.openTodoModal = function(todoId = null) {
        const form = document.getElementById('todoForm');
        const modal = new bootstrap.Modal(document.getElementById('todoModal'));
        form.reset();

        if (todoId) {
            document.getElementById('todoModalTitle').textContent = 'Edit To-Do';
            document.getElementById('todoSubmitText').textContent = 'Update To-Do';
            document.getElementById('todoMethod').value = 'PUT';
            form.action = '{{ route("property-management.dashboard") }}/todos/' + todoId;

            fetch('{{ route("property-management.dashboard") }}/todos/' + todoId + '/data')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('todo_title').value = data.title || '';
                    document.getElementById('todo_description').value = data.description || '';
                    document.getElementById('todo_priority').value = data.priority || 'medium';
                    document.getElementById('todo_status').value = data.status || 'pending';
                    document.getElementById('todo_due_date').value = data.due_date || '';
                    document.getElementById('todo_type').value = data.type || 'To-Do';
                });
        } else {
            document.getElementById('todoModalTitle').textContent = 'Add To-Do';
            document.getElementById('todoSubmitText').textContent = 'Add To-Do';
            document.getElementById('todoMethod').value = 'POST';
            form.action = '{{ route("todo-list.store") }}';
        }
        modal.show();
    };
});
</script>
