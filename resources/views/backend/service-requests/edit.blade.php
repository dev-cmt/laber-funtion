<x-backend-layout title="Edit Service Request">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Edit Service Request</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Update Customer Information</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('service-requests.update', $serviceRequest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="customer_name" 
                                           value="{{ old('customer_name', $serviceRequest->customer_name) }}" required>
                                    @error('customer_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="customer_phone" 
                                           value="{{ old('customer_phone', $serviceRequest->customer_phone) }}" required>
                                    @error('customer_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="customer_address" rows="3" required>{{ old('customer_address', $serviceRequest->customer_address) }}</textarea>
                                    @error('customer_address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Customer Notes</label>
                                    <textarea class="form-control" name="customer_notes" rows="3">{{ old('customer_notes', $serviceRequest->customer_notes) }}</textarea>
                                    @error('customer_notes')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('service-requests.show', $serviceRequest) }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-backend-layout>