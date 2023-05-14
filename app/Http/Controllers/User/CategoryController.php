<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Category $category)
    {
        return inertia('User/Category', [
            'category'  => $category,
            'products'  => $category->products->whereHas('oldestImage')->first()->load(
                'oldestImage:id,images.product_id,name',
                'colors:id,name,hexa'
            ),
        ]);
    }
}
