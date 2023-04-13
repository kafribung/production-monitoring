<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'color_id'   => 'bail|required|numeric',
            'quantity'   => 'bail|required|numeric',
            'size_id'    => 'bail|required|numeric',
            'product_id' => 'bail|required|numeric',
            'custom_id'  => 'nullable',
            'note'       => 'nullable',
        ]);

        $product = Product::find($data['product_id'], ['id', 'slug', 'price']);

        // Set Price
        $data['price'] = $product->price * $data['quantity'];

        // Check cart
        // $cart = Cart::where(function ($q) use ($data) {
        //     $q->where('color_id', $data['color_id'])
        //         ->where('quantity', $data['quantity'])
        //         ->where('size_id', $data['size_id'])
        //         ->where('product_id', $data['product_id']);
        // })->first(['id']);
        // End check cart

        DB::transaction(function () use ($data) {
            Cart::create(
                $data
            );
        });

        Session::flash('message', 'Produk ditambahkan ke keranjang');
        return to_route('detail.index', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        Session::flash('message', 'Product successfully remove from cart');
        return back();
    }
}
