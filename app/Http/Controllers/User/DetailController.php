<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product)
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
}
