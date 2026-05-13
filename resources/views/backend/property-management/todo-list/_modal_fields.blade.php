{{-- Reusable Todo List modal fields --}}
@php $isTemplate = $isTemplate ?? false; $tv = fn($f) => (!$isTemplate && $todo) ? ($todo->$f ?? '') : ''; @endphp

<div class="row g-sm-4 g-3">
    {{-- Header Options --}}
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase"><i class="ri-list-check-line me-1 text-primary"></i> Entry Type <span class="text-danger">*</span></label>
        <select name="type" class="form-select border-primary border-opacity-25" required>
            <option value="To-Do"       {{ $tv('type') === 'To-Do'       ? 'selected' : '' }}>To-Do List</option>
            <option value="Appointment" {{ $tv('type') === 'Appointment' ? 'selected' : '' }}>Appointment</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase"><i class="ri-loader-3-line me-1 text-primary"></i> Current Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select border-primary border-opacity-25" required>
            <option value="Open"      {{ $tv('status') === 'Open'      ? 'selected' : '' }}>Open / Active</option>
            <option value="Done"      {{ $tv('status') === 'Done'      ? 'selected' : '' }}>Done / Completed</option>
            <option value="Postponed" {{ $tv('status') === 'Postponed' ? 'selected' : '' }}>Postponed</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase"><i class="ri-calendar-event-line me-1 text-primary"></i> Due Date / Time</label>
        <input type="datetime-local" name="due_date" class="form-control"
            value="{{ (!$isTemplate && $todo && $todo->due_date) ? \Carbon\Carbon::parse($todo->due_date)->format('Y-m-d\TH:i') : '' }}">
    </div>

    {{-- Details & Location --}}
    <div class="col-md-12">
        <div class="card custom-card border shadow-none mb-0 bg-light">
            <div class="card-body p-sm-3 p-2">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase">Location / Site Details</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="ri-map-pin-line text-muted"></i></span>
                            <input type="text" name="location" class="form-control border-start-0 ps-0"
                                placeholder="e.g. 10 Baker Street, London"
                                value="{{ $tv('location') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-muted fs-12 mb-1 uppercase">Task Details / Notes</label>
                        <textarea name="details" class="form-control bg-white" rows="5"
                            placeholder="Describe the task or appointment in detail...">{{ $tv('details') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
