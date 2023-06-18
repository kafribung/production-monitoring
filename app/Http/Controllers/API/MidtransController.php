<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $serverKey    = env('MIDTRANS_SERVER_KEY');
        $clientKey    = env('MIDTRANS_CLIENT_KEY');
        $isProduction = false;
        $is3ds        = true;
        $isSanitized  = true;

        $midtransClient = \Sawirricardo\Midtrans\Midtrans::make(
            $serverKey,
            $clientKey,
            $isProduction,
            $is3ds,
            $isSanitized
        );

        $transaction_details = json_encode($request->transaction_details);
        $transaction_details = json_decode($transaction_details);
        $checkout_order_id   = $transaction_details->order_id;

        $auth    = json_encode($request->auth);
        $auth    = json_decode($auth);

        // Get checkout
        $checkout = Checkout::where('order_number', $checkout_order_id)->first();

        // Get status API Midtrans
        $transaction_status  = $midtransClient->payment()->status($checkout_order_id);

        $transaction  = $transaction_status->transaction_status;
        $type         = $transaction_status->payment_type;
        $order_id     = $transaction_status->order_id;
        $fraud        = $transaction_status->fraud_status;
        $message      = 'ok';

        if ($checkout->status != 'success') {
            if ($transaction == 'capture') {
                // For credit card transaction, we need to check whether transaction is challenge by FDS or not
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        // TODO set payment status in merchant's database to 'Challenge by FDS'
                        // TODO merchant should decide whether this transaction is authorized or not in MAP
                        $message = "Transaction order_id: " . $order_id . " is challenged by FDS";
                    } else {
                        // TODO set payment status in merchant's database to 'Success'
                        $message = "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                        // Update checkouts table
                        $checkout->update([
                            'status' => 'success'
                        ]);
                        // Update product
                        $this->updateStockLastProduct($checkout);
                    }
                }
            } elseif ($transaction == 'settlement') {
                // TODO set payment status in merchant's database to 'Settlement'
                $message = "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
                // Update checkouts table
                $checkout->update([
                    'status' => 'success'
                ]);
                // Update product
                $this->updateStockLastProduct($checkout);
            } elseif ($transaction == 'pending') {
                // TODO set payment status in merchant's database to 'Pending'
                $message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
            } elseif ($transaction == 'deny') {
                // TODO set payment status in merchant's database to 'Denied'
                $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";

                // Delete checkout
                $this->delete($checkout);
            } elseif ($transaction == 'expire') {
                // TODO set payment status in merchant's database to 'expire'
                $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";

                // Delete checkout
                $this->delete($checkout);
            } elseif ($transaction == 'cancel') {
                // TODO set payment status in merchant's database to 'Denied'
                $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";

                // Delete checkout
                $this->delete($checkout);
            } elseif ($transaction == null) {
                $snap_token = $midtransClient->snap()->create(new \Sawirricardo\Midtrans\Dto\TransactionDto($request->all()));

                return response([
                    'data' => [
                        'token'  => $snap_token->token,
                        'redirect_url' => $snap_token->redirect_url,
                        'message' => $message
                    ]
                ]);
            }

            return response([
                'data' => [
                    'message'            => $message,
                    'order_id'           => $order_id,
                    'gross_amount'       => $transaction_status->gross_amount,
                    'va_numbers'         => $transaction_status->va_numbers,
                    'transaction_time'   => $transaction_status->transaction_time,
                    'expiry_time'        => $transaction_status->expiry_time,
                    'transaction_status' => $transaction_status->transaction_status,
                ]
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $serverKey    = env('MIDTRANS_SERVER_KEY');
        $clientKey    = env('MIDTRANS_CLIENT_KEY');
        $isProduction = false;
        $is3ds        = true;
        $isSanitized  = true;

        $midtransClient = \Sawirricardo\Midtrans\Midtrans::make(
            $serverKey,
            $clientKey,
            $isProduction,
            $is3ds,
            $isSanitized
        );

        $transaction_details = json_encode($request->transaction_details);
        $transaction_details = json_decode($transaction_details);
        $checkout_order_id   = $transaction_details->order_id;

        $auth    = json_encode($request->auth);
        $auth    = json_decode($auth);

        // Get checkout
        $checkout = Checkout::where('order_number', $checkout_order_id)->first();
        // Get status API Midtrans
        $transaction_status  = $midtransClient->payment()->status($checkout_order_id);

        $transaction  = $transaction_status->transaction_status;
        $type         = $transaction_status->payment_type;
        $fraud        = $transaction_status->fraud_status;

        // If not checkout
        if ($checkout->status != 'success') {
            if ($transaction == 'capture') {
                // For credit card transaction, we need to check whether transaction is challenge by FDS or not
                if ($type == 'credit_card') {
                    if ($fraud != 'challenge') {
                        // Update checkouts table
                        $checkout->update([
                            'status' => 'success'
                        ]);
                        // Update product
                        $this->updateStockLastProduct($checkout);
                    }
                }
            } elseif ($transaction == 'settlement') {
                // Update checkouts table
                $checkout->update([
                    'status' => 'success'
                ]);
                // Update product
                $this->updateStockLastProduct($checkout);
            } elseif ($transaction == 'pending') {
                $checkout->update([
                    'status' => 'pending'
                ]);
            } elseif ($transaction == 'deny') {
                // Delete checkout
                $this->delete($checkout);
            } elseif ($transaction == 'expire') {
                // Delete checkout
                $this->delete($checkout);
            } elseif ($transaction == 'cancel') {
                $this->delete($checkout);
            }
        }


        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  obj  $checkout
     * @return \Illuminate\Http\Response
     */
    public function delete($checkout)
    {
        // Delete checkouts table
        $checkout->checkoutCarts->each(function ($cart) {
            $cart->delete();
        });
        $checkout->delete();
        // End Delete checkouts table
    }

    /**
     * Update the specified resource from storage.
     *
     * @param  obj  $checkout
     * @return \Illuminate\Http\Response
     */
    public function updateStockLastProduct($checkout)
    {
        $checkout->checkoutCarts->each(function ($checkout_cart) {
            $checkout_cart->cart->product->update([
                'stock_last' =>  $checkout_cart->cart->product->stock_last ? $checkout_cart->cart->product->stock_last + $checkout_cart->cart->quantity : $checkout_cart->cart->quantity
            ]);
        });
    }
}
