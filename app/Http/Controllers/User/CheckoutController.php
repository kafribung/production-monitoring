<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class CheckoutController extends Controller
{
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

        return Inertia::render('User/Checkout', compact('provinces', 'districts', 'costs', 'province_id'));
    }

    /**
     * Display the district.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDistrict($province_id)
    {
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
        $province_id =  json_decode($response)->rajaongkir->query->province;

        return Inertia::render('User/Checkout', compact('districts', 'province_id'));
    }

    /**
     * Show the form for creating the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCost($dest_id)
    {

        $district = curl_init();
        $province = curl_init();

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

        curl_setopt_array($province, array(
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


        $districts = curl_exec($district);
        $err = curl_error($district);
        curl_close($district);
        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $provinces = curl_exec($province);
        $err = curl_error($province);
        curl_close($province);
        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $districts =  json_decode($districts)->rajaongkir->results;
        $provinces =  json_decode($provinces)->rajaongkir->results;

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

        return Inertia::render('User/Checkout', compact('districts', 'provinces', 'province_id', 'district_id'));
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
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
    public function destroy()
    {
        abort(404);
    }
}
