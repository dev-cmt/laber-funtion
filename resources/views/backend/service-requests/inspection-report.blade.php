<x-backend-layout title="Inspection Report">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Inspection Report</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Inspection Report</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Submit Inspection Report</div>
                </div>
                <div class="card-body">
                    
                    {{-- Customer Info Card --}}
                    <div class="card bg-light border mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Customer:</strong> {{ $serviceRequest->customer_name }}</p>
                                    <p class="mb-1"><strong>Phone:</strong> {{ $serviceRequest->customer_phone }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Assigned To:</strong> {{ $serviceRequest->assignedEmployee->name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Visit Date:</strong> {{ $serviceRequest->visit_date ? date('d M, Y', strtotime($serviceRequest->visit_date)) : 'N/A' }}</p>
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

                    <form action="{{ route('service-requests.inspection-report.store', $serviceRequest) }}" method="POST" id="inspectionForm">
                        @csrf
                        
                        {{-- Technician Notes --}}
                        <div class="mb-4">
                            <label class="form-label">Technician Notes <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('technician_notes') is-invalid @enderror" 
                                      name="technician_notes" 
                                      rows="6"
                                      placeholder="Describe the inspection findings, issues identified, and recommendations..."
                                      required>{{ old('technician_notes', $serviceRequest->technician_notes ?? '') }}</textarea>
                            @error('technician_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Provide detailed notes about the inspection</small>
                        </div>

                        {{-- Products Required Section --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label">Products Required <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-primary" id="addProduct">
                                    <i class="ri-add-line me-1"></i> Add Product
                                </button>
                            </div>
                            
                            <div id="productsContainer">
                                @php
                                    $oldProducts = old('products', []);
                                    $existingProducts = $serviceRequest->products ?? [];
                                @endphp
                                
                                @if(count($existingProducts) > 0)
                                    @foreach($existingProducts as $index => $product)
                                        <div class="product-row border rounded p-3 mb-3">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product <span class="text-danger">*</span></label>
                                                        <select class="form-select product-select" name="products[{{ $index }}][product_id]" required>
                                                            <option value="">-- Select Product --</option>
                                                            @foreach($products as $productItem)
                                                                <option value="{{ $productItem->id }}" 
                                                                    {{ $product->product_id == $productItem->id ? 'selected' : '' }}>
                                                                    {{ $productItem->name }} ({{ $productItem->code }})
                                                                    @if($productItem->stock)
                                                                        - Stock: {{ $productItem->stock }}
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                        <input type="number" 
                                                               class="form-control" 
                                                               name="products[{{ $index }}][quantity]" 
                                                               value="{{ $product->quantity }}"
                                                               min="1"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Notes</label>
                                                        <input type="text" 
                                                               class="form-control" 
                                                               name="products[{{ $index }}][notes]" 
                                                               value="{{ $product->notes ?? '' }}"
                                                               placeholder="Any specific notes...">
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm remove-product">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @elseif(count($oldProducts) > 0)
                                    @foreach($oldProducts as $index => $oldProduct)
                                        <div class="product-row border rounded p-3 mb-3">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product <span class="text-danger">*</span></label>
                                                        <select class="form-select product-select" name="products[{{ $index }}][product_id]" required>
                                                            <option value="">-- Select Product --</option>
                                                            @foreach($products as $productItem)
                                                                <option value="{{ $productItem->id }}" 
                                                                    {{ $oldProduct['product_id'] == $productItem->id ? 'selected' : '' }}>
                                                                    {{ $productItem->name }} ({{ $productItem->code }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                        <input type="number" 
                                                               class="form-control" 
                                                               name="products[{{ $index }}][quantity]" 
                                                               value="{{ $oldProduct['quantity'] ?? 1 }}"
                                                               min="1"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Notes</label>
                                                        <input type="text" 
                                                               class="form-control" 
                                                               name="products[{{ $index }}][notes]" 
                                                               value="{{ $oldProduct['notes'] ?? '' }}"
                                                               placeholder="Any specific notes...">
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm remove-product">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="product-row border rounded p-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label class="form-label">Product <span class="text-danger">*</span></label>
                                                    <select class="form-select product-select" name="products[0][product_id]" required>
                                                        <option value="">-- Select Product --</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->name }} ({{ $product->code }})
                                                                @if($product->stock)
                                                                    - Stock: {{ $product->stock }}
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" 
                                                           class="form-control" 
                                                           name="products[0][quantity]" 
                                                           value="1"
                                                           min="1"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Notes</label>
                                                    <input type="text" 
                                                           class="form-control" 
                                                           name="products[0][notes]" 
                                                           value=""
                                                           placeholder="Any specific notes...">
                                                </div>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div id="noProductsAlert" class="alert alert-warning d-none">
                                <i class="ri-alert-line me-2"></i>
                                Please add at least one product to the inspection report.
                            </div>
                        </div>

                        {{-- Additional Information --}}
                        <div class="mb-4">
                            <label class="form-label">Additional Recommendations</label>
                            <textarea class="form-control" 
                                      name="additional_recommendations" 
                                      rows="3"
                                      placeholder="Any additional recommendations for the customer...">{{ old('additional_recommendations') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Estimated Service Time (Hours)</label>
                                    <input type="number" 
                                           class="form-control" 
                                           name="estimated_service_hours" 
                                           value="{{ old('estimated_service_hours', 2) }}"
                                           min="1" 
                                           max="24"
                                           step="0.5">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Service Urgency</label>
                                    <select class="form-select" name="service_urgency">
                                        <option value="routine" {{ old('service_urgency') == 'routine' ? 'selected' : '' }}>Routine (Within 7 days)</option>
                                        <option value="urgent" {{ old('service_urgency') == 'urgent' ? 'selected' : '' }}>Urgent (Within 48 hours)</option>
                                        <option value="emergency" {{ old('service_urgency') == 'emergency' ? 'selected' : '' }}>Emergency (Immediate)</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Estimated Cost</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" 
                                               class="form-control" 
                                               name="estimated_cost" 
                                               value="{{ old('estimated_cost') }}"
                                               min="0"
                                               step="0.01">
                                    </div>
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
                                    <i class="ri-file-text-line me-1"></i> Submit Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        $(document).ready(function() {
            let productIndex = {{ count($existingProducts) > 0 ? count($existingProducts) : (count($oldProducts) > 0 ? count($oldProducts) : 1) }};
            
            // Add product row
            $('#addProduct').click(function() {
                const productRow = `
                    <div class="product-row border rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Product <span class="text-danger">*</span></label>
                                    <select class="form-select product-select" name="products[${productIndex}][product_id]" required>
                                        <option value="">-- Select Product --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }} ({{ $product->code }})
                                                @if($product->stock)
                                                    - Stock: {{ $product->stock }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control" 
                                           name="products[${productIndex}][quantity]" 
                                           value="1"
                                           min="1"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="products[${productIndex}][notes]" 
                                           value=""
                                           placeholder="Any specific notes...">
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#productsContainer').append(productRow);
                productIndex++;
                
                // Initialize select2 for new row
                $('.product-select:last').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Search and select product',
                    allowClear: true,
                    width: '100%'
                });
                
                updateNoProductsAlert();
            });
            
            // Remove product row
            $(document).on('click', '.remove-product', function() {
                if ($('.product-row').length > 1) {
                    $(this).closest('.product-row').remove();
                    updateNoProductsAlert();
                    reindexProducts();
                } else {
                    alert('At least one product is required.');
                }
            });
            
            // Initialize select2 for existing selects
            $('.product-select').select2({
                theme: 'bootstrap-5',
                placeholder: 'Search and select product',
                allowClear: true,
                width: '100%'
            });
            
            // Form validation
            $('#inspectionForm').submit(function(e) {
                const technicianNotes = $('textarea[name="technician_notes"]').val().trim();
                const productCount = $('.product-row').length;
                let isValid = true;
                
                if (!technicianNotes) {
                    e.preventDefault();
                    alert('Please provide technician notes.');
                    $('textarea[name="technician_notes"]').focus();
                    return false;
                }
                
                // Validate each product row
                $('.product-row').each(function(index) {
                    const productSelect = $(this).find('.product-select');
                    const quantityInput = $(this).find('input[name$="[quantity]"]');
                    
                    if (!productSelect.val()) {
                        isValid = false;
                        productSelect.focus();
                    }
                    
                    if (!quantityInput.val() || parseInt(quantityInput.val()) < 1) {
                        isValid = false;
                        quantityInput.focus();
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required product fields.');
                    return false;
                }
                
                if (productCount === 0) {
                    e.preventDefault();
                    $('#noProductsAlert').removeClass('d-none');
                    return false;
                }
                
                return true;
            });
            
            function updateNoProductsAlert() {
                const productCount = $('.product-row').length;
                if (productCount === 0) {
                    $('#noProductsAlert').removeClass('d-none');
                } else {
                    $('#noProductsAlert').addClass('d-none');
                }
            }
            
            function reindexProducts() {
                productIndex = 0;
                $('.product-row').each(function(index) {
                    $(this).find('select, input').each(function() {
                        const name = $(this).attr('name');
                        if (name) {
                            const newName = name.replace(/\[\d+\]/, `[${index}]`);
                            $(this).attr('name', newName);
                        }
                    });
                    productIndex++;
                });
            }
            
            // Auto-calculate estimated cost based on products
            $(document).on('change', '.product-select, input[name$="[quantity]"]', function() {
                calculateEstimatedCost();
            });
            
            function calculateEstimatedCost() {
                let totalCost = 0;
                
                $('.product-row').each(function() {
                    const productSelect = $(this).find('.product-select');
                    const quantityInput = $(this).find('input[name$="[quantity]"]');
                    const selectedOption = productSelect.find('option:selected');
                    
                    if (selectedOption.length > 0) {
                        // Extract price from option text or data attribute
                        const optionText = selectedOption.text();
                        const priceMatch = optionText.match(/৳(\d+(\.\d+)?)/);
                        
                        if (priceMatch) {
                            const price = parseFloat(priceMatch[1]);
                            const quantity = parseInt(quantityInput.val()) || 0;
                            totalCost += price * quantity;
                        }
                    }
                });
                
                if (totalCost > 0) {
                    $('input[name="estimated_cost"]').val(totalCost.toFixed(2));
                }
            }
        });
    </script>
    @endpush
</x-backend-layout>