<x-backend-layout title="Create Sale Requisition">
    <style>
        #file-upload-input {
            display: none; 
        }
        #image-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px 0px 0px 10px;
        }

        .image-preview-btn {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 4px; 
            background-color: #f8f9fa; 
            display: block;
        }

        .input-group .btn-light {
            border-radius: 0;
            border-right: 0;
        }

        
    </style>
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Create Sale Requisition</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sale-requisitions.index') }}">Sale Requisition</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <form action="{{ route('sale-requisitions.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-8 mx-auto">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <section class="bg-primary-gradient py-5 rounded-3 mb-4 shadow-sm">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-xxl-10 col-xl-11">
                                        <div class="text-center mb-4">
                                            <h4 class="text-fixed-white fw-bold">Quick Product Search</h4>
                                            <p class="text-fixed-white opacity-75">Search by Name or SKU to add products instantly</p>
                                        </div>
                                        
                                        <div class="position-relative search-container">
                                            <div class="input-group input-group-lg shadow-lg overflow-hidden rounded-pill">
                                                <span class="input-group-text bg-white border-0 ps-4">
                                                    <i class="bi bi-search text-primary fs-5"></i>
                                                </span>
                                                <input type="text" id="productSearchInput" 
                                                    class="form-control border-0 py-3 ps-2 fs-5" 
                                                    placeholder="Start typing product name or SKU..." 
                                                    autocomplete="off">
                                                
                                                <label id="image-search-label" for="file-upload-input" 
                                                    class="btn btn-white border-0 d-flex align-items-center px-4" 
                                                    data-bs-toggle="tooltip" title="Search by Image">
                                                    <input type="file" id="file-upload-input" accept="image/*" class="d-none">
                                                    <i class="bi bi-camera text-muted fs-4"></i>
                                                </label>

                                                <button class="btn btn-dark px-5 fw-bold" type="button" id="searchButton">
                                                    SEARCH
                                                </button>
                                            </div>

                                            <!-- Search Results Dropdown -->
                                            <div id="searchResults" class="search-results-dropdown shadow-lg d-none">
                                                <div class="list-group list-group-flush" id="resultsList">
                                                    <!-- Results will be injected here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <style>
                            .bg-primary-gradient {
                                background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
                            }
                            .search-container .form-control:focus {
                                box-shadow: none;
                            }
                            .search-results-dropdown {
                                position: absolute;
                                top: 100%;
                                left: 0;
                                right: 0;
                                z-index: 1050;
                                background: white;
                                border-radius: 15px;
                                margin-top: 10px;
                                max-height: 400px;
                                overflow-y: auto;
                                border: 1px solid rgba(0,0,0,0.1);
                            }
                            .search-result-item {
                                padding: 12px 20px;
                                transition: all 0.2s;
                                cursor: pointer;
                                border-bottom: 1px solid #f8f9fa;
                            }
                            .search-result-item:hover {
                                background-color: #f0f4ff;
                            }
                            .search-result-item:last-child {
                                border-bottom: 0;
                            }
                            .result-thumb {
                                width: 45px;
                                height: 45px;
                                object-fit: cover;
                                border-radius: 8px;
                                margin-right: 15px;
                            }
                            .result-price {
                                font-weight: 700;
                                color: #224abe;
                            }
                            .btn-white {
                                background: white;
                                color: #6c757d;
                            }
                            .btn-white:hover {
                                color: #4e73df;
                            }

                            /* Table & Card Enhancements */
                            #order-items-table {
                                border-collapse: separate;
                                border-spacing: 0 8px;
                            }
                            #order-items-table thead th {
                                border: none;
                                background-color: #f8f9fa;
                                color: #495057;
                                font-weight: 600;
                                padding: 15px;
                                text-transform: uppercase;
                                font-size: 0.75rem;
                                letter-spacing: 1px;
                            }
                            #order-items-body tr {
                                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
                                border-radius: 10px;
                                transition: all 0.2s;
                            }
                            #order-items-body tr:hover {
                                transform: translateY(-2px);
                                box-shadow: 0 4px 8px rgba(0,0,0,0.05);
                                background-color: #fff;
                            }
                            #order-items-body td {
                                vertical-align: middle;
                                padding: 15px;
                                border: none;
                                background-color: #fff;
                            }
                            #order-items-body td:first-child { border-radius: 10px 0 0 10px; }
                            #order-items-body td:last-child { border-radius: 0 10px 10px 0; }
                            
                            .summary-card {
                                border: none;
                                border-radius: 15px;
                                overflow: hidden;
                            }
                            .summary-card .card-header {
                                background-color: #224abe;
                                color: white;
                                border: none;
                                padding: 15px 20px;
                            }
                            .summary-card .form-label {
                                font-weight: 600;
                                color: #495057;
                                font-size: 0.85rem;
                            }
                            .summary-card .form-control[readonly] {
                                background-color: #f8f9fa;
                                border-color: #e9ecef;
                                font-weight: 700;
                                color: #224abe;
                            }
                        </style>

                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const searchInput = document.getElementById('productSearchInput');
                                const resultsList = document.getElementById('resultsList');
                                const searchResults = document.getElementById('searchResults');
                                let debounceTimer;

                                searchInput.addEventListener('input', function() {
                                    clearTimeout(debounceTimer);
                                    const query = this.value.trim();

                                    if (query.length < 2) {
                                        searchResults.classList.add('d-none');
                                        return;
                                    }

                                    debounceTimer = setTimeout(() => {
                                        fetch(`{{ route('products.search') }}?query=${encodeURIComponent(query)}`)
                                            .then(response => response.json())
                                            .then(data => {
                                                resultsList.innerHTML = '';
                                                if (data.length > 0) {
                                                    data.forEach(product => {
                                                        const item = document.createElement('div');
                                                        item.className = 'search-result-item d-flex align-items-center';
                                                        const imagePath = product.image ? `/uploads/products/${product.image}` : '/assets/images/no-image.png';
                                                        
                                                        item.innerHTML = `
                                                            <img src="${imagePath}" class="result-thumb" onerror="this.src='/assets/images/no-image.png'">
                                                            <div class="flex-grow-1">
                                                                <div class="fw-bold text-dark">${product.name}</div>
                                                                <small class="text-muted">SKU: ${product.sku}</small>
                                                            </div>
                                                            <div class="text-end ps-3">
                                                                <div class="result-price">৳${parseFloat(product.sale_price).toLocaleString()}</div>
                                                                <button type="button" class="btn btn-sm btn-primary-light mt-1 add-to-table" 
                                                                    data-id="${product.id}" 
                                                                    data-name="${product.name}" 
                                                                    data-sku="${product.sku}" 
                                                                    data-price="${product.sale_price}">
                                                                    Add
                                                                </button>
                                                            </div>
                                                        `;
                                                        
                                                        item.onclick = (e) => {
                                                            if(!e.target.classList.contains('add-to-table')) {
                                                                addProductToTable(product);
                                                                searchResults.classList.add('d-none');
                                                                searchInput.value = '';
                                                            }
                                                        };
                                                        
                                                        resultsList.appendChild(item);
                                                    });
                                                    
                                                    // Handle 'Add' button specifically
                                                    resultsList.querySelectorAll('.add-to-table').forEach(btn => {
                                                        btn.onclick = (e) => {
                                                            e.stopPropagation();
                                                            const product = {
                                                                id: btn.dataset.id,
                                                                name: btn.dataset.name,
                                                                sku: btn.dataset.sku,
                                                                sale_price: btn.dataset.price
                                                            };
                                                            addProductToTable(product);
                                                            searchResults.classList.add('d-none');
                                                            searchInput.value = '';
                                                        };
                                                    });

                                                    searchResults.classList.remove('d-none');
                                                } else {
                                                    resultsList.innerHTML = '<div class="p-4 text-center text-muted">No products found</div>';
                                                    searchResults.classList.remove('d-none');
                                                }
                                            });
                                    }, 300);
                                });

                                // Close dropdown when clicking outside
                                document.addEventListener('click', function(e) {
                                    if (!searchResults.contains(e.target) && e.target !== searchInput) {
                                        searchResults.classList.add('d-none');
                                    }
                                });

                                function addProductToTable(product) {
                                    // Implementation of adding row to the table
                                    // This will call the existing createItemRow or similar
                                    const row = createItemRow({
                                        product_id: product.id,
                                        product: { name: product.name },
                                        sku: product.sku,
                                        sale_price: product.sale_price,
                                        quantity: 1
                                    });
                                    
                                    // Remove empty message if exists
                                    const emptyMsg = document.querySelector('#order-items-body tr .text-muted');
                                    if (emptyMsg) emptyMsg.closest('tr').remove();
                                    
                                    $('#order-items-body').append(row);
                                    calculateOrderSummary();
                                }
                            });
                        </script>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-nowrap" id="order-items-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40%;">Product</th>
                                        <th style="width: 15%;">SKU</th>
                                        <th style="width: 10%;">Qty</th>
                                        <th style="width: 15%;">Sale Price</th>
                                        <th style="width: 15%;">Subtotal</th>
                                        <th style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="order-items-body">
                                    {{-- Dynamic rows will be added here --}}
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Search and add products above.</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-end">
                                            <button type="button" class="btn btn-lg btn-info shadow-sm" id="add-item-btn">
                                                <i class="bi bi-plus-circle me-1"></i> Add Product Manually
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                    </div>

                    <div class="col-xl-4">
                        <div class="card custom-card summary-card shadow-sm">
                            <div class="card-header"><div class="card-title text-fixed-white">Summary & Status</div></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Invoice No <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="invoice_no" value="{{ old('invoice_no', 'REQ-' . time()) }}" required readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Store <span class="text-danger">*</span></label>
                                        <select class="form-select" name="store_id" required>
                                            <option value="">Select Store</option>
                                            @foreach($stores as $store)
                                                <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Source</label>
                                        <select class="form-select" name="source">
                                            @foreach(['Facebook', 'Website', 'Walk-in', 'Referral', 'Other'] as $source)
                                                <option value="{{ $source }}" {{ old('source') == $source ? 'selected' : '' }}>{{ $source }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Existing Customer</label>
                                        <select class="form-select" name="customer_id" id="customer_select">
                                            <option value="">Search/Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" data-name="{{ $customer->name }}" data-phone="{{ $customer->phone }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->phone }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Customer Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="customer_phone" value="{{ old('customer_phone') }}" required>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="customer_address" rows="2">{{ old('customer_address') }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Sub Total</label>
                                        <input type="number" class="form-control" name="sub_total" id="sub_total" value="{{ old('sub_total', 0) }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Shipping Cost</label>
                                        <input type="number" class="form-control" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost', 0) }}" step="0.01" min="0">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Discount</label>
                                        <input type="number" class="form-control" name="discount" id="discount" value="{{ old('discount', 0) }}" step="0.01" min="0">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Total Amount</label>
                                        <input type="number" class="form-control" name="total" id="total" value="{{ old('total', 0) }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Paid Amount <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="paid" id="paid" value="{{ old('paid', 0) }}" step="0.01" min="0" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Due Amount</label>
                                        <input type="number" class="form-control" name="due" id="due" value="{{ old('due', 0) }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                        <select class="form-select" name="payment_method" required>
                                            @foreach($paymentMethods as $key => $method)
                                                <option value="{{ $key }}" {{ (int) old('payment_method', 0) === $key ? 'selected' : '' }}>
                                                    {{ $method }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Payment Status <span class="text-danger">*</span></label>
                                        <select class="form-select" name="payment_status" required>
                                            @foreach($paymentStatuses as $key => $status)
                                                <option value="{{ $key }}" {{ (int) old('payment_status', 0) === $key ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Order Status <span class="text-danger">*</span></label>
                                        <select class="form-select" name="status" required>
                                            @foreach($orderStatuses as $key => $status)
                                                <option value="{{ $key }}" {{ (int) old('status', 0) === $key ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Assigned To</label>
                                        <select class="form-select" name="assigned_to">
                                            <option value="">Select Employee</option>
                                            @foreach($employees as $user)
                                                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Notes</label>
                                        <textarea class="form-control" name="notes" rows="2">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Place Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
    <script>
        const productsData = @json($products->keyBy('id'));
        let itemIndex = 0;

        // --- Core Functions ---

        // Function to create an item row HTML
        function createItemRow(item = {}) {
            const index = item.id ? 'existing-' + item.id : itemIndex++;
            const productId = item.product_id || '';
            const productName = item.product ? item.product.name : 'Select Product';
            const sku = item.sku || '';
            const quantity = item.quantity || 1;
            const salePrice = item.sale_price || 0;
            const subtotal = (quantity * salePrice).toFixed(2);
            
            // Hidden fields for what's not in the table view
            const purchasePrice = item.purchase_price || 0; 
            const attributes = item.attributes ? JSON.stringify(item.attributes) : '[]';

            let itemInputId = item.id ? `items[${index}][id]` : '';

            return `
                <tr data-index="${index}">
                    ${item.id ? `<input type="hidden" name="items[${index}][id]" value="${item.id}">` : ''}
                    <input type="hidden" name="items[${index}][purchase_price]" value="${purchasePrice}" class="item-purchase-price">
                    <input type="hidden" name="items[${index}][attributes]" value='${attributes}'>
                    
                    <td>
                        <select class="form-select product-select" name="items[${index}][product_id]" required data-index="${index}">
                            <option value="">${productName}</option>
                            @foreach($products as $product)
                                <option 
                                    value="{{ $product->id }}" 
                                    data-price="{{ $product->sale_price }}" 
                                    data-sku="{{ $product->sku }}" >
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm item-sku" name="items[${index}][sku]" value="${sku}" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm item-qty" name="items[${index}][quantity]" value="${quantity}" min="1" required data-index="${index}">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm item-price" name="items[${index}][sale_price]" value="${salePrice}" step="0.01" min="0" required data-index="${index}">
                    </td>
                    <td class="item-subtotal-display">${subtotal}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger-light remove-item-btn"><i class="ri-delete-bin-line"></i></button>
                    </td>
                    
                </tr>
            `;
        }

        // Function to update the subtotal for an item row
        function updateItemSubtotal(row) {
            const qty = parseFloat(row.find('.item-qty').val()) || 0;
            const price = parseFloat(row.find('.item-price').val()) || 0;
            const subtotal = (qty * price).toFixed(2);
            row.find('.item-subtotal-display').text(subtotal);
            calculateOrderSummary();
        }

        function calculateOrderSummary() {
            let subTotal = 0;
            $('#order-items-body tr').each(function() {
                const row = $(this);
                const qty = parseFloat(row.find('.item-qty').val()) || 0;
                const price = parseFloat(row.find('.item-price').val()) || 0;
                subTotal += (qty * price);
            });

            const shippingCost = parseFloat($('#shipping_cost').val()) || 0;
            const discount = parseFloat($('#discount').val()) || 0;
            const paid = parseFloat($('#paid').val()) || 0;

            const total = (subTotal + shippingCost - discount);
            const due = (total - paid);

            $('#sub_total').val(subTotal.toFixed(2));
            $('#total').val(Math.max(0, total).toFixed(2));
            $('#due').val(due.toFixed(2));
            
            // Update payment status based on due amount
            if (total > 0 && due <= 0) {
                $('select[name="payment_status"]').val('2'); // Paid
            } else if (paid > 0 && due > 0) {
                $('select[name="payment_status"]').val('1'); // Partial
            } else {
                $('select[name="payment_status"]').val('0'); // Pending
            }
        }

        // --- Event Listeners ---

        $(document).ready(function() {
            // Initial load: add one empty item row for new order
            if ($('#order-items-body tr').length === 0) {
                 $('#order-items-body').append(createItemRow());
            }

            // Add Item Button
            $('#add-item-btn').on('click', function() {
                $('#order-items-body').append(createItemRow());
            });

            // Remove Item Button
            $('#order-items-body').on('click', '.remove-item-btn', function() {
                $(this).closest('tr').remove();
                calculateOrderSummary();
            });

            // Product Selection Change
            $('#order-items-body').on('change', '.product-select', function() {
                const select = $(this);
                const row = select.closest('tr');
                const selectedOption = select.find('option:selected');
                const price = parseFloat(selectedOption.data('price')) || 0;
                const sku = selectedOption.data('sku') || '';

                row.find('.item-price').val(price.toFixed(2));
                row.find('.item-sku').val(sku);
                row.find('.item-qty').val(1); // Reset quantity on product change
                
                updateItemSubtotal(row);
            });

            // Quantity or Price Change
            $('#order-items-body').on('input', '.item-qty, .item-price', function() {
                updateItemSubtotal($(this).closest('tr'));
            });

            // Summary Field Change
            $('#shipping_cost, #discount, #paid').on('input', function() {
                calculateOrderSummary();
            });
            
            // Customer Select Change (Pre-fill name and phone)
            $('#customer_select').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const name = selectedOption.data('name');
                const phone = selectedOption.data('phone');
                
                if (name) {
                    $('input[name="customer_name"]').val(name);
                    $('input[name="customer_phone"]').val(phone);
                } else {
                    // Clear fields if 'Select Customer' is chosen
                    $('input[name="customer_name"]').val('');
                    $('input[name="customer_phone"]').val('');
                }
            });

            // Initial calculation on page load (in case of old input errors)
            calculateOrderSummary();
        });
    </script>
    @endpush
</x-backend-layout>