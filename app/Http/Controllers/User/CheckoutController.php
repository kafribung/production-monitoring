<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // abort_if(Cart::where('status', false)->count() == 0, 404);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $province_id = null, int $dest_id = null)
    {
        $districts   = null;
        $costs       = null;
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~API Raja ongkir get province
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                env('RAJA_ONGKIR_KEY')
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
        $provinces =  json_decode($response)->rajaongkir->results;

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~End API Raja ongkir get province


        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~API Raja ongkir get district
        if ($province_id) {
            $district = curl_init();

            curl_setopt_array($district, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province={$province_id}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    env('RAJA_ONGKIR_KEY')
                ),
            ));

            $response = curl_exec($district);
            $err = curl_error($district);
            curl_close($district);
            if ($err) {
                echo "cURL Error #:" . $err;
            }
            $districts   =  json_decode($response)->rajaongkir->results;
        }
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~End API Raja ongkir get district

        if ($dest_id) {
            $costs = curl_init();

            curl_setopt_array($costs, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=254&destination={$dest_id}&weight=1700&courier=jne",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    env('RAJA_ONGKIR_KEY')
                ),
            ));

            $response = curl_exec($costs);
            $err = curl_error($costs);

            curl_close($costs);

            if ($err) {
                echo "cURL Error #:" . $err;
            }

            $costs =  json_decode($response)->rajaongkir->results;
        }

        return Inertia::render('User/Checkout', compact('provinces', 'districts', 'costs', 'province_id', 'dest_id'));
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'address' => 'bail|required|string',
            'phone' => 'bail|required|numeric|max_digits:13',
            'province_id' => 'bail|required|numeric',
            'district_id' => 'bail|required|numeric',
            'subtotal' => 'bail|required|numeric',
            'shipping' => 'bail|required|numeric',
            'total' => 'bail|required|numeric',
        ]);

        $data['status'] = 'pending';
        $carts = Cart::where([['status', false], ['created_by', auth()->id()]])->get(['id']);

        $data['order_number'] =  date('Ymd') . time() .  strtoupper(substr(uniqid(sha1(time())), 0, 4));

        DB::transaction(function () use ($data, $carts) {
            // Insert to checkouts table
            $checkout = Checkout::create($data);

            // Insert to checkout_carts table
            $carts->each(fn ($cart) =>  $checkout->checkoutCarts()->create([
                'cart_id' => $cart->id
            ]));

            // Update carts table
            $carts->each(fn ($cart) =>  $cart->update([
                'status' => true
            ]));
        });

        return to_route('checkout.show');
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return Inertia::render('User/CheckoutDetail', [
            'checkouts' => Checkout::with([
                'createdBy:id,name,email',
                'checkoutCarts.cart.product:id,name,slug',
                'checkoutCarts.cart.product.oldestImage:id,images.product_id,name',
                'checkoutCarts.cart.color:id,name,hexa',
                'checkoutCarts.cart.size:id,name',
                'checkoutCarts.cart.custom:id,name',
            ])
                ->where('created_by', auth()->id())
                ->latest()
                ->get([
                    'id',
                    'order_number',
                    'address',
                    'phone',
                    'subtotal',
                    'shipping',
                    'total',
                    'status',
                    'province_id',
                    'district_id',
                    'created_by'
                ])
        ]);
    }

    /**
     * Update the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkout $checkout)
    {
        DB::transaction(function () use ($checkout) {
            $checkout->checkoutCarts->each(function ($checkout_cart) {
                $checkout_cart->delete();
            });

            $checkout->delete();
        });

        Session::flash('message', 'Orderan berhasil dihapus');
        return to_route('checkout.show');
    }
}
