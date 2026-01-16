<x-backend-layout title="Assign Inspection">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Assign Inspection</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('service-requests.index') }}">Service Requests</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('service-requests.show', $serviceRequest) }}">
                            SR-{{ str_pad($serviceRequest->id, 6, '0', STR_PAD_LEFT) }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Assign Inspection</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Assign Technician for Inspection</div>
                </div>
                <div class="card-body">
                    
                    {{-- Customer Info Card --}}
                    <div class="card bg-light border mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Customer:</strong> {{ $serviceRequest->customer_name }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Phone:</strong> {{ $serviceRequest->customer_phone }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Address:</strong> {{ $serviceRequest->customer_address }}</p>
                                </div>
                            </div>
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('service-requests.assign-inspection.store', $serviceRequest) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            {{-- Technician Selection --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Select Technician <span class="text-danger">*</span></label>
                                    <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id" required>
                                        <option value="">-- Select Technician --</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" 
                                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }} - {{ $employee->phone }}
                                                @if($employee->designation)
                                                    ({{ $employee->designation }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Visit Date --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Visit Date <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('visit_date') is-invalid @enderror" 
                                           name="visit_date" 
                                           id="visit_date"
                                           value="{{ old('visit_date') }}"
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                    @error('visit_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Select the date for on-site inspection</small>
                                </div>
                            </div>

                            {{-- Visit Time --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Preferred Time</label>
                                    <select class="form-select" name="visit_time">
                                        <option value="">-- Select Time Slot --</option>
                                        <option value="9:00-11:00" {{ old('visit_time') == '9:00-11:00' ? 'selected' : '' }}>Morning (9:00 AM - 11:00 AM)</option>
                                        <option value="11:00-13:00" {{ old('visit_time') == '11:00-13:00' ? 'selected' : '' }}>Late Morning (11:00 AM - 1:00 PM)</option>
                                        <option value="14:00-16:00" {{ old('visit_time') == '14:00-16:00' ? 'selected' : '' }}>Afternoon (2:00 PM - 4:00 PM)</option>
                                        <option value="16:00-18:00" {{ old('visit_time') == '16:00-18:00' ? 'selected' : '' }}>Evening (4:00 PM - 6:00 PM)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Priority --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select class="form-select" name="priority">
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }} selected>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Assignment Notes --}}
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Assignment Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              name="notes" 
                                              rows="4"
                                              placeholder="Add any specific instructions for the technician...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">These notes will be visible to the assigned technician</small>
                                </div>
                            </div>

                            {{-- Customer Notes Preview --}}
                            @if($serviceRequest->customer_notes)
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Customer's Original Notes</label>
                                    <div class="border rounded p-3 bg-light">
                                        <p class="mb-0">{{ $serviceRequest->customer_notes }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Estimated Duration --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Estimated Duration (Hours)</label>
                                    <input type="number" 
                                           class="form-control" 
                                           name="estimated_hours" 
                                           value="{{ old('estimated_hours', 2) }}"
                                           min="1" 
                                           max="8"
                                           step="0.5">
                                    <small class="text-muted">Estimated time required for inspection</small>
                                </div>
                            </div>

                            {{-- Required Tools --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Required Tools/Equipment</label>
                                    <select class="form-select" name="required_tools[]" multiple id="requiredTools">
                                        <option value="multimeter" {{ in_array('multimeter', old('required_tools', [])) ? 'selected' : '' }}>Multimeter</option>
                                        <option value="screwdriver_set" {{ in_array('screwdriver_set', old('required_tools', [])) ? 'selected' : '' }}>Screwdriver Set</option>
                                        <option value="pliers" {{ in_array('pliers', old('required_tools', [])) ? 'selected' : '' }}>Pliers</option>
                                        <option value="voltage_tester" {{ in_array('voltage_tester', old('required_tools', [])) ? 'selected' : '' }}>Voltage Tester</option>
                                        <option value="wire_cutter" {{ in_array('wire_cutter', old('required_tools', [])) ? 'selected' : '' }}>Wire Cutter</option>
                                        <option value="thermometer" {{ in_array('thermometer', old('required_tools', [])) ? 'selected' : '' }}>Thermometer</option>
                                        <option value="camera" {{ in_array('camera', old('required_tools', [])) ? 'selected' : '' }}>Camera</option>
                                        <option value="ladder" {{ in_array('ladder', old('required_tools', [])) ? 'selected' : '' }}>Ladder</option>
                                        <option value="safety_kit" {{ in_array('safety_kit', old('required_tools', [])) ? 'selected' : '' }}>Safety Kit</option>
                                    </select>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple tools</small>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <a href="{{ route('service-requests.show', $serviceRequest) }}" class="btn btn-light">
                                    <i class="ri-arrow-left-line me-1"></i> Back to Request
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-user-add-line me-1"></i> Assign Inspection
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Available Technicians Summary --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Available Technicians</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Designation</th>
                                    <th>Active Assignments</th>
                                    <th>Skills</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $employee)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($employee->avatar)
                                                    <img src="{{ asset($employee->avatar) }}" 
                                                         class="rounded-circle me-2" 
                                                         width="32" 
                                                         height="32" 
                                                         alt="{{ $employee->name }}">
                                                @else
                                                    <div class="rounded-circle me-2 bg-primary text-white d-flex align-items-center justify-content-center" 
                                                         style="width: 32px; height: 32px;">
                                                        {{ substr($employee->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <span>{{ $employee->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $employee->phone }}</td>
                                        <td>
                                            <span class="badge bg-info-transparent">
                                                {{ $employee->designation ?? 'Technician' }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $activeAssignments = \App\Models\ServiceRequest::where('assigned_to', $employee->id)
                                                    ->whereIn('status', ['assigned', 'inspected'])
                                                    ->count();
                                            @endphp
                                            <span class="badge bg-{{ $activeAssignments < 3 ? 'success' : ($activeAssignments < 5 ? 'warning' : 'danger') }}-transparent">
                                                {{ $activeAssignments }} active
                                            </span>
                                        </td>
                                        <td>
                                            @if($employee->skills)
                                                @foreach(explode(',', $employee->skills) as $skill)
                                                    <span class="badge bg-light text-dark border me-1 mb-1">{{ trim($skill) }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $employee->is_active ? 'success' : 'danger' }}-transparent">
                                                {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No technicians available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    <style>
        #requiredTools {
            height: 120px;
        }
        .employee-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        .employee-initials {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #4e73df;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
    @endpush

    @push('js')
    <script>
        $(document).ready(function() {
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            $('#visit_date').attr('min', today);
            
            // Auto-select tomorrow as default visit date
            if (!$('#visit_date').val()) {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const tomorrowStr = tomorrow.toISOString().split('T')[0];
                $('#visit_date').val(tomorrowStr);
            }
            
            // Initialize select2 for better multi-select UI
            $('#requiredTools').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select required tools',
                allowClear: true,
                width: '100%'
            });
            
            // Initialize employee select with search
            $('#employee_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Search and select technician',
                allowClear: true,
                width: '100%'
            });
            
            // Form validation
            $('form').submit(function(e) {
                const employeeId = $('#employee_id').val();
                const visitDate = $('#visit_date').val();
                
                if (!employeeId) {
                    e.preventDefault();
                    alert('Please select a technician');
                    $('#employee_id').focus();
                    return false;
                }
                
                if (!visitDate) {
                    e.preventDefault();
                    alert('Please select a visit date');
                    $('#visit_date').focus();
                    return false;
                }
                
                return true;
            });
        });
    </script>
    @endpush
</x-backend-layout>