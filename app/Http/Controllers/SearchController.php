<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggest(Request $request)
    {
        $search = $request->get('search');
        
        if (empty($search)) {
            return response()->json([]);
        }

        $products = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('sku', 'like', '%' . $search . '%')
            ->active()
            ->take(5)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => number_format($product->sale_price, 2),
                    'regular_price' => number_format($product->regular_price, 2),
                    'image' => $product->main_image ? asset($product->main_image) : asset('images/no-image.jpg'),
                    'url' => route('product.show', $product->slug),
                ];
            });

        return response()->json($products);
    }
}
