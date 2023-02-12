<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

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
     * Chart a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chart(Request $request)
    {
        dd($request);
        $data = $request->validate([
            'color_id' => 'bail|required|numeric',
            'qunatity' => 'bail|required|numeric',
        ]);

        // $product = Product::find('');
        // return to_route('home');
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
