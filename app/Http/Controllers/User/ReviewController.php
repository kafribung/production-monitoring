<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CheckoutCart;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CheckoutCart $checkout_cart)
    {
        return Inertia::render('User/Review', [
            'checkout_cart_id' => $checkout_cart->id,
            'product'          => $checkout_cart->cart->product->name,
            'star'             => $checkout_cart->review->star ?? null,
            'value'          => $checkout_cart->review->value ?? null,
        ]);
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
    public function update(Request $request, CheckoutCart $checkout_cart)
    {
        $data = $request->validate([
            'star'   => 'bail|required|numeric',
            'value'   => 'bail|required|string',
        ]);

        $data['checkout_cart_id']  = $checkout_cart->id;

        if (Review::where('checkout_cart_id', $checkout_cart->id)->count()) {
            $data['updated_by'] = auth()->id();
        } else {
            $data['created_by'] = auth()->id();
        }

        Review::updateOrCreate(
            ['checkout_cart_id' => $checkout_cart->id],
            $data
        );

        Session::flash('message', 'Produk berhasil direview');
        return to_route('checkout.show');
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
