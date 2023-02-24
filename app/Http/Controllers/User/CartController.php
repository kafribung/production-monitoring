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
            'color_id' => 'bail|required|numeric',
            'qunatity' => 'bail|required|numeric',
            'size_id' => 'bail|required|numeric',
            'product_id' => 'bail|required|numeric',
        ]);

        $product = Product::find($data['product_id'], ['id', 'slug', 'price']);
        // Set Price
        $data['price'] = $product->price;

        // Check cart
        $cart = Cart::where(function ($q) use ($data) {
            $q->where('color_id', $data['color_id'])
                ->where('qunatity', $data['qunatity'])
                ->where('size_id', $data['size_id'])
                ->where('product_id', $data['product_id']);
        })->first(['id']);

        DB::transaction(function () use ($data, $cart) {
            Cart::updateOrCreate(
                ['id' => $cart->id ?? null],
                $data
            );
        });
        Session::flash('message', 'Product successfully added to cart');
        return to_route('detail.index', $product);
    }
}
