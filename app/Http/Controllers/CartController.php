<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    private function cart()
    {
        return Cart::session(auth()->id() ?? session()->getId());
    }

    /* ADD TO CART */
    public function add(Request $request)
    {
        $request->validate([
            'id'    => 'required',
            'name'  => 'required',
            'price' => 'required|numeric',
            'qty'   => 'required|integer|min:1',
        ]);

        $this->cart()->add([
            'id'       => (string) $request->id,
            'name'     => $request->name,
            'price'    => (float) $request->price,
            'quantity' => (int) $request->qty,
            'attributes' => [
                'image' => $request->image ?? '',
                'url'   => $request->url ?? '#',
            ],
        ]);

        return $this->mini();
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
