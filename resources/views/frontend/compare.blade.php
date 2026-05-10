<x-frontend-layout title="Compare" :breadcrumbs="$breadcrumbs" :seotags="$seotags">
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
                        <li class="breadcrumb-item active" aria-current="page">Compare</li>
                    </ol>
                </nav>
            </div>
            <div class="page-header__title">
                <h1>Compare</h1>
            </div>
        </div>
    </div>
    
    <div class="block">
        <div class="container">
            @php
                $compare = \Cart::session((Auth::id() ?? session()->getId()) . '_compare')->getContent();
            @endphp
            @if($compare->count() > 0)
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="table-responsive">
                <table class="compare-table">
                    <tbody>
                        <tr class="compare-table__row">
                            <th class="compare-table__column compare-table__column--header">Product</th>
                            @foreach($compare as $item)
                            <td class="compare-table__column compare-table__column--product">
                                <a href="{{ $item->attributes->url }}" class="compare-table__product-link">
                                    <div class="compare-table__product-image">
                                        <img src="{{ $item->attributes->image }}" alt="" width="200" height="200">
                                    </div>
                                    <div class="compare-table__product-name">{{ $item->name }}</div>
                                </a>
                            </td>
                            @endforeach
                        </tr>
                        <tr class="compare-table__row">
                            <th class="compare-table__column compare-table__column--header">Availability</th>
                            @foreach($compare as $item)
                            <td class="compare-table__column compare-table__column--product">
                                <span class="badge badge-success">{{ $item->attributes->stock }}</span>
                            </td>
                            @endforeach
                        </tr>
                        <tr class="compare-table__row">
                            <th class="compare-table__column compare-table__column--header">Price</th>
                            @foreach($compare as $item)
                            <td class="compare-table__column compare-table__column--product">${{ number_format($item->price, 2) }}</td>
                            @endforeach
                        </tr>
                        <tr class="compare-table__row">
                            <th class="compare-table__column compare-table__column--header">Add to cart</th>
                            @foreach($compare as $item)
                            <td class="compare-table__column compare-table__column--product">
                                <button type="button" class="btn btn-primary btn-sm btn-cart" 
                                    data-id="{{ $item->id }}" 
                                    data-name="{{ $item->name }}" 
                                    data-price="{{ $item->price }}" 
                                    data-image="{{ $item->attributes->image }}" 
                                    data-url="{{ $item->attributes->url }}">Add to cart</button>
                            </td>
                            @endforeach
                        </tr>
                        <tr class="compare-table__row">
                            <th class="compare-table__column compare-table__column--header">SKU</th>
                            @foreach($compare as $item)
                            <td class="compare-table__column compare-table__column--product">{{ $item->attributes->sku }}</td>
                            @endforeach
                        </tr>
                        <tr class="compare-table__row">
                            <th class="compare-table__column compare-table__column--header">Brand</th>
                            @foreach($compare as $item)
                            <td class="compare-table__column compare-table__column--product">{{ $item->attributes->brand }}</td>
                            @endforeach
                        </tr>
                        <tr class="compare-table__row">
                            <th class="compare-table__column compare-table__column--header">Remove</th>
                            @foreach($compare as $item)
                            <td class="compare-table__column compare-table__column--product">
                                <form action="{{ route('compare.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary btn-sm">Remove</button>
                                </form>
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center pb-5 pt-5">
                <h3 class="mb-4">Your compare list is empty</h3>
                <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
            @endif
        </div>
    </div>
</x-frontend-layout>
