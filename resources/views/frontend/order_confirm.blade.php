<x-frontend-layout title="Order Confirmation">
    <div class="premium-confirmation-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    
                    <div class="confirmation-card text-center">
                        <div class="success-checkmark">
                            <div class="check-icon">
                                <span class="icon-line line-tip"></span>
                                <span class="icon-line line-long"></span>
                                <div class="icon-circle"></div>
                                <div class="icon-fix"></div>
                            </div>
                        </div>
                        
                        <h1 class="success-title">Thank You For Your Order!</h1>
                        <p class="success-subtitle">We've received your order and are getting it ready for shipment.</p>
                        
                        <div class="order-details-box text-left mt-5">
                            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                                <div>
                                    <span class="text-muted small text-uppercase font-weight-bold">Order Number</span>
                                    <h4 class="mb-0 text-dark">{{ $order->invoice_no }}</h4>
                                </div>
                                <div class="text-right">
                                    <span class="text-muted small text-uppercase font-weight-bold">Date</span>
                                    <h4 class="mb-0 text-dark" style="font-size: 16px;">{{ $order->created_at->format('M d, Y') }}</h4>
                                </div>
                            </div>
                            
                            <div class="order-items-wrapper mb-4">
                                @foreach($order->items as $item)
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom-dashed">
                                    <div class="item-name text-truncate pr-3" style="max-width: 70%; font-weight: 500;">
                                        {{ $item->product->name ?? 'Product' }} <span class="text-muted ml-1">x{{ $item->quantity }}</span>
                                    </div>
                                    <div class="item-price font-weight-bold">
                                        ${{ number_format($item->sale_price * $item->quantity, 2) }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted">Subtotal</span>
                                <span>${{ number_format($order->sub_total, 2) }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted">Shipping</span>
                                <span class="text-success">Free</span>
                            </div>
                            
                            <div class="d-flex justify-content-between py-3 mt-2 border-top">
                                <span class="font-weight-bold text-dark" style="font-size: 18px;">Total</span>
                                <span class="font-weight-bold" style="font-size: 24px; color: #e53935;">${{ number_format($order->total, 2) }}</span>
                            </div>
                            
                            <div class="payment-method-badge mt-3">
                                <i class="fas fa-money-bill-wave mr-2"></i> 
                                Payment Method: <strong>{{ $order->payment_method == 0 ? 'Cash' : 'Cash on Delivery' }}</strong>
                            </div>
                        </div>
                        
                        <div class="mt-5 d-flex justify-content-center gap-3 action-buttons">
                            <a href="{{ route('home') }}" class="btn-continue-shopping mr-3">
                                <i class="fas fa-home mr-2"></i> Return Home
                            </a>
                            <a href="{{ route('shop') }}" class="btn-premium">
                                Continue Shopping <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    @push('css')
    <style>
        .premium-confirmation-container {
            padding: 80px 0;
            background: #fdfdfd;
            min-height: 70vh;
            display: flex;
            align-items: center;
        }
        
        .confirmation-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            padding: 50px 40px;
            border: 1px solid rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }
        
        .confirmation-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #4caf50 0%, #81c784 100%);
        }
        
        .success-title {
            font-size: 32px;
            font-weight: 800;
            color: #1a1a1a;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        
        .success-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }
        
        .order-details-box {
            background: #f9f9f9;
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #eee;
        }
        
        .border-bottom-dashed {
            border-bottom: 1px dashed #e0e0e0;
        }
        
        .payment-method-badge {
            background: rgba(229, 57, 53, 0.05);
            color: #e53935;
            padding: 10px 15px;
            border-radius: 8px;
            display: inline-block;
            font-size: 14px;
        }
        
        /* Buttons */
        .btn-premium {
            background: linear-gradient(135deg, #e53935 0%, #b71c1c 100%);
            color: white !important;
            border: none;
            border-radius: 30px;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(229, 57, 53, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
        }
        
        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(229, 57, 53, 0.4);
            text-decoration: none;
        }
        
        .btn-continue-shopping {
            background: #fff;
            color: #333 !important;
            border: 2px solid #eee;
            border-radius: 30px;
            padding: 12px 28px;
            font-size: 16px;
            font-weight: 600;
            display: inline-block;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .btn-continue-shopping:hover {
            background: #f5f5f5;
            border-color: #ddd;
            text-decoration: none;
        }
        
        @media (max-width: 576px) {
            .action-buttons {
                flex-direction: column;
            }
            .action-buttons a {
                margin-bottom: 10px;
                margin-right: 0 !important;
            }
            .confirmation-card {
                padding: 40px 20px;
            }
        }
        
        /* Checkmark Animation */
        .success-checkmark {
            width: 80px;
            height: 115px;
            margin: 0 auto;
        }
        .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid #4CAF50;
        }
        .check-icon::before {
            top: 3px;
            left: -2px;
            width: 30px;
            transform-origin: 100% 50%;
            border-radius: 100px 0 0 100px;
        }
        .check-icon::after {
            top: 0;
            left: 30px;
            width: 60px;
            transform-origin: 0 50%;
            border-radius: 0 100px 100px 0;
            animation: rotate-circle 4.25s ease-in;
        }
        .check-icon::before, .check-icon::after {
            content: '';
            height: 100px;
            position: absolute;
            background: #fff;
            transform: rotate(-45deg);
        }
        .icon-line {
            height: 5px;
            background-color: #4CAF50;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
        }
        .icon-line.line-tip {
            top: 46px;
            left: 14px;
            width: 25px;
            transform: rotate(45deg);
            animation: icon-line-tip 0.75s;
        }
        .icon-line.line-long {
            top: 38px;
            right: 8px;
            width: 47px;
            transform: rotate(-45deg);
            animation: icon-line-long 0.75s;
        }
        .icon-circle {
            top: -4px;
            left: -4px;
            z-index: 10;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            position: absolute;
            box-sizing: content-box;
            border: 4px solid rgba(76, 175, 80, .5);
        }
        .icon-fix {
            top: 8px;
            width: 5px;
            left: 26px;
            z-index: 1;
            height: 85px;
            position: absolute;
            transform: rotate(-45deg);
            background-color: #fff;
        }
        @keyframes icon-line-tip {
            0% { width: 0; left: 1px; top: 19px; }
            54% { width: 0; left: 1px; top: 19px; }
            70% { width: 50px; left: -8px; top: 37px; }
            84% { width: 17px; left: 21px; top: 48px; }
            100% { width: 25px; left: 14px; top: 46px; }
        }
        @keyframes icon-line-long {
            0% { width: 0; right: 46px; top: 54px; }
            65% { width: 0; right: 46px; top: 54px; }
            84% { width: 55px; right: 0px; top: 35px; }
            100% { width: 47px; right: 8px; top: 38px; }
        }
    </style>
    @endpush
</x-frontend-layout>
