<x-frontend-layout title="Shopping Cart" :breadcrumbs="$breadcrumbs" :seotags="$seotags">
    <div class="page-header">
        <div class="page-header__container container">
            <div class="page-header__breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Home</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="{{ asset('frontend/images/sprite.svg#arrow-rounded-right-6x9') }}"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>Shopping Cart</h1>
            </div>
        </div>
    </div>
    <div class="cart block">
        <div class="container">
            @php
                $cart = \Cart::session(Auth::id() ?? session()->getId());
                $items = $cart->getContent()->sortBy('id');
            @endphp
            @if($items->count() > 0)
                <table class="cart__table cart-table">
                    <thead class="cart-table__head">
                        <tr class="cart-table__row">
                            <th class="cart-table__column cart-table__column--image">Image</th>
                            <th class="cart-table__column cart-table__column--product">Product</th>
                            <th class="cart-table__column cart-table__column--price">Price</th>
                            <th class="cart-table__column cart-table__column--quantity">Quantity</th>
                            <th class="cart-table__column cart-table__column--total">Total</th>
                            <th class="cart-table__column cart-table__column--remove"></th>
                        </tr>
                    </thead>
                    <tbody class="cart-table__body">
                        @foreach($items as $item)
                        <tr class="cart-table__row" data-id="{{ $item->id }}">
                            <td class="cart-table__column cart-table__column--image">
                                <a href="{{ $item->attributes->url ?? '#' }}">
                                    <img src="{{ $item->attributes->image ?? asset('images/no-image.jpg') }}" alt="">
                                </a>
                            </td>
                            <td class="cart-table__column cart-table__column--product">
                                <a href="{{ $item->attributes->url ?? '#' }}" class="cart-table__product-name">{{ $item->name }}</a>
                                @if(isset($item->attributes->attributes) && is_array($item->attributes->attributes))
                                <ul class="cart-table__options">
                                    <li>Variant details can go here...</li>
                                </ul>
                                @endif
                            </td>
                            <td class="cart-table__column cart-table__column--price" data-title="Price">${{ number_format($item->price, 2) }}</td>
                            <td class="cart-table__column cart-table__column--quantity" data-title="Quantity">
                                <div class="input-number">
                                    <input class="form-control input-number__input cart-update-qty" type="number" min="1" value="{{ $item->quantity }}" data-id="{{ $item->id }}">
                                    <div class="input-number__add"></div>
                                    <div class="input-number__sub"></div>
                                </div>
                            </td>
                            <td class="cart-table__column cart-table__column--total" data-title="Total">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            <td class="cart-table__column cart-table__column--remove">
                                <button type="button" class="btn btn-light btn-sm btn-svg-icon remove-cart" data-id="{{ $item->id }}">
                                    <svg width="12px" height="12px"><use xlink:href="{{asset('frontend')}}/images/sprite.svg#cross-12"></use></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="cart__actions">
                    <form class="cart__coupon-form" onsubmit="return false;">
                        <label for="input-coupon-code" class="sr-only">Password</label>
                        <input type="text" class="form-control" id="input-coupon-code" placeholder="Coupon Code">
                        <button type="submit" class="btn btn-primary">Apply Coupon</button>
                    </form>
                    <div class="cart__buttons">
                        <a href="{{ url('/') }}" class="btn btn-light">Continue Shopping</a>
                    </div>
                </div>
                <div class="row justify-content-end pt-5">
                    <div class="col-12 col-md-7 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Cart Totals</h3>
                                <table class="cart__totals">
                                    <thead class="cart__totals-header">
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>${{ number_format($cart->getSubTotal(), 2) }}</td>
                                        </tr>
                                    </thead>
                                    <tbody class="cart__totals-body">
                                        <tr>
                                            <th>Shipping</th>
                                            <td>
                                                Calculated at checkout
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="cart__totals-footer">
                                        <tr>
                                            <th>Total</th>
                                            <td>${{ number_format($cart->getTotal(), 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a class="btn btn-primary btn-xl btn-block cart__checkout-button" href="{{ route('checkout') }}">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center pb-5 pt-5">
                    <h3 class="mb-4">Your shopping cart is empty</h3>
                    <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @endif
        </div>
    </div>
    
    @push('js')
    <script>
        $(document).ready(function() {
            // Update quantity
            $('.cart-update-qty').on('change', function() {
                let id = $(this).data('id');
                let qty = $(this).val();
                $.ajax({
                    url: "{{ route('cart.update.qty') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        qty: qty
                    },
                    success: function() {
                        location.reload();
                    }
                });
            });

            // The .remove-cart button click is intercepted by master.blade.php globally.
            // When it finishes, we should reload the cart page to update totals.
            $(document).on('click', '.remove-cart', function() {
                setTimeout(() => location.reload(), 600);
            });
        });
    </script>
    @endpush
</x-frontend-layout>
