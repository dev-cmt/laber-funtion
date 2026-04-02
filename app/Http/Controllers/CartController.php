<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Product;
use App\Models\ProductVariant;

class CartController extends Controller
{
    private function cart()
    {
        return Cart::session(Auth::user()->id ?? session()->getId());
    }

    public function addCart(Request $request)
    {
        $quantity = $request->qty ?? 1;
        $product = Product::find($request->product_id);
        if (! $product) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Product not found'])
                : back()->with('error', 'Product not found');
        }

        // ---------- Variant logic ----------
        $variantKey = null;

        if ($request->attribute_item_id && is_array($request->attribute_item_id)) {
            $variantKey = strtolower(implode('-', $request->attribute_item_id));
        }

        $variant = null;

        if ($variantKey) {
            $variant = ProductVariant::where('product_id', $product->id)->where('variant', $variantKey)->first();
        }

        $sku   = $variant->sku ?? $product->sku;
        $name  = $variant->product->name ?? $product->name;
        $price = $variant ? $variant->sale_price : $product->sale_price;

        // ---------- Cart logic ----------
        if (Cart::get($sku)) {
            Cart::update($sku, [
                'quantity' => [
                    'relative' => false,
                    'value' => $quantity,
                ],
            ]);
        } else {
            Cart::add([
                'id' => $sku,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'attributes' => $variantKey ?? null,
                'associatedModel' => $product,
            ]);
        }

        // ---------- AJAX response ----------
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'count'   => Cart::getTotalQuantity()
            ]);
        }

        // ---------- Normal fallback ----------
        if ($request->order_now) {
            return $theme->is_active
                ? redirect()->route('checkout')
                : redirect()->route('theme.checkout', ['path' => $theme->path]);
        }
    }
    public function cartItemPlus(Request $request, Theme $theme, $id)
    {
        // Check cart item exists
        $item = Cart::get($request->id);
        if (! $item) {
            return response()->json(['error' => 'Cart item not found']);
        }

        if (Cart::getContent()->count() > 0) {
            Cart::update($request->id, [
                'quantity' => 1,
            ]);

            return response()->json(['success' => 'Cart quantity updated successfully!']);
        } else {
            return response()->json(['error' => 'error']);
        }
    }
    public function cartItemMinus(Request $request, Theme $theme, $id)
    {
        $item = Cart::get($request->id);
        if (! $item) {
            return response()->json(['error' => 'Cart item not found']);
        }

        if (Cart::getContent()->count() > 0) {
            Cart::update($request->id, [
                'quantity' => -1,
            ]);

            return response()->json(['success' => 'Cart quantity updated successfully!']);
        } else {
            return response()->json(['error' => 'error']);
        }
    }
    public function cartItemDelete(Request $request)
    {
        Cart::remove($request->id);
        $total = Cart::getTotal();
        $total_cart = count(Cart::getContent());
        if ($request->ajax()) {
            return response()->json([
                'success' => 'Cart Item Deleted Successfully.',
                'total' => $total,
                'total_cart' => $total_cart,
            ]);
        } else {
            return back()->with('success', 'Cart item delete successfully.');
        }
    }
    public function cartClear()
    {
        Cart::clear();

        return response()->json([
            'success' => 200,
            'message' => 'Cart cleared successfully',
        ]);
    }




    /* ADD TO CART */
    public function add(Request $request)
    {
        $cartItem = Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'qty' => 1,
            'price' => $request->price,
            'options' => [
                'image' => $request->image,
                'url' => $request->url,
            ]
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product added successfully',
            'cart_count' => Cart::count(),
            'cart_total' => Cart::total()
        ]);
    }

    /* UPDATE QTY */
    public function updateQty(Request $request)
    {
        $request->validate([
            'id'  => 'required',
            'qty' => 'required|integer|min:1',
        ]);

        $this->cart()->update($request->id, [
            'quantity' => [
                'relative' => false,
                'value'    => $request->qty,
            ],
        ]);

        return $this->mini();
    }

    /* REMOVE ITEM */
    public function remove($id)
    {
        $this->cart()->remove($id);
        return $this->mini();
    }

    /* MINI CART JSON */
    public function mini()
    {
        return response()->json([
            'count'    => $this->cart()->getTotalQuantity(),
            'subtotal' => number_format($this->cart()->getSubTotal(), 2),
            'items'    => $this->cart()->getContent()->values(),
        ]);
    }
}
