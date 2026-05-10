<x-frontend-layout title="Checkout" :breadcrumbs="$breadcrumbs" :seotags="$seotags">
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
                        <li class="breadcrumb-item">
                            <a href="{{ route('cart') }}">Cart</a>
                            <svg class="breadcrumb-arrow" width="6px" height="9px">
                                <use xlink:href="{{ asset('frontend/images/sprite.svg#arrow-rounded-right-6x9') }}"></use>
                            </svg>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>Checkout</h1>
            </div>
        </div>
    </div>
    
    <div class="checkout block">
        <div class="container">
            @php
                $cart = \Cart::session(Auth::id() ?? session()->getId());
                $items = $cart->getContent();
            @endphp
            @if($items->count() > 0)
            <form action="{{ route('place.order') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-7">
                        <div class="card mb-lg-0">
                            <div class="card-body">
                                <h3 class="card-title">Billing details</h3>
                                
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="checkout-first-name">First Name</label>
                                        <input type="text" class="form-control" id="checkout-first-name" name="first_name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="checkout-last-name">Last Name</label>
                                        <input type="text" class="form-control" id="checkout-last-name" name="last_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="checkout-phone">Phone</label>
                                    <input type="text" class="form-control" id="checkout-phone" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="checkout-email">Email address</label>
                                    <input type="email" class="form-control" id="checkout-email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="checkout-address">Address</label>
                                    <input type="text" class="form-control" id="checkout-address" name="address" required>
                                </div>
                                <div class="form-group">
                                    <label for="checkout-city">Town / City</label>
                                    <input type="text" class="form-control" id="checkout-city" name="city" required>
                                </div>
                                <div class="form-group">
                                    <label for="checkout-comment">Order notes <span class="text-muted">(Optional)</span></label>
                                    <textarea id="checkout-comment" class="form-control" name="note" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-5 mt-4 mt-lg-0">
                        <div class="card mb-0">
                            <div class="card-body">
                                <h3 class="card-title">Your Order</h3>
                                <table class="checkout__totals">
                                    <thead class="checkout__totals-header">
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="checkout__totals-products">
                                        @foreach($items as $item)
                                        <tr>
                                            <td>{{ $item->name }} × {{ $item->quantity }}</td>
                                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody class="checkout__totals-subtotals">
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>${{ number_format($cart->getSubTotal(), 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <td>$0.00</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="checkout__totals-footer">
                                        <tr>
                                            <th>Total</th>
                                            <td>${{ number_format($cart->getTotal(), 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="payment-methods">
                                    <ul class="payment-methods__list">
                                        <li class="payment-methods__item payment-methods__item--active">
                                            <label class="payment-methods__item-header">
                                                <span class="payment-methods__item-radio input-radio">
                                                    <span class="input-radio__body">
                                                        <input class="input-radio__input" name="payment_method" type="radio" checked value="cod">
                                                        <span class="input-radio__circle"></span>
                                                    </span>
                                                </span>
                                                <span class="payment-methods__item-title">Cash on delivery</span>
                                            </label>
                                            <div class="payment-methods__item-container">
                                                <div class="payment-methods__item-description text-muted">
                                                    Pay with cash upon delivery.
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="checkout__agree form-group">
                                    <div class="form-check">
                                        <span class="form-check-input input-check">
                                            <span class="input-check__body">
                                                <input class="input-check__input" type="checkbox" id="checkout-terms" required>
                                                <span class="input-check__box"></span>
                                                <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="{{asset('frontend')}}/images/sprite.svg#check-9x7"></use></svg>
                                            </span>
                                        </span>
                                        <label class="form-check-label" for="checkout-terms">
                                            I have read and agree to the website <a target="_blank" href="#">terms and conditions</a>*
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-xl btn-block">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @else
                <div class="text-center pb-5 pt-5">
                    <h3 class="mb-4">Your shopping cart is empty</h3>
                    <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @endif
        </div>
    </div>
</x-frontend-layout>
