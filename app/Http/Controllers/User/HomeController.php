<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(
            'oldestImage:id,images.product_id,name',
            'colors:id,name,hexa'
        )
            ->limit(10)->get(['id', 'name', 'slug', 'price']);

        return Inertia::render('User/Home', compact('products'));
    }
}
