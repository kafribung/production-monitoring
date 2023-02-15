<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $product = $product->load([
            'images:id,images.product_id,name',
            'colors:id,name,hexa',
            'colors:id,name,hexa',
            'materil:id,name',
            'sizes:id,name',
        ])
            ->only([
                'id',
                'name',
                'price',
                'description',
                'images',
                'colors',
                'materil',
                'sizes',
                'stock_first'
            ]);

        // dd($product['sizes'][0]['id']);
        return inertia('User/Detail', [
            'product' => $product,
        ]);
    }


    /**
     * Cart a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cart(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
