<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'carts' => [
                'cart' => $request->user() ? $request->user()->carts()->where('status', false)->get(['id', 'product_id', 'color_id', 'size_id', 'price', 'quantity', 'custom_id', 'note'])->load(['product:id,name,slug', 'product.oldestImage:id,images.product_id,name', 'color:id,hexa', 'size:id,name', 'custom:id,name']) : null,
                'sub_total' => $request->user() ? $request->user()->carts->where('status', false)->sum('sub_total') : null,
            ],
            'categories' => Category::get(['name', 'id']),
        ]);
    }
}
