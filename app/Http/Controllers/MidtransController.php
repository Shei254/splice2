<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserCoupon;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MidtransController extends Controller
{
    public function planPayWithMidtrans(Request $request)
    {
        $payment_setting = Utility::payment_settings();
        $midtrans_secret = $payment_setting['midtrans_secret'];
        $midtrans_mode = $payment_setting['midtrans_mode'];

        $currency = isset($payment_setting['currency']) ? $payment_setting['currency'] : 'USD';

        $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan = Plan::find($planID);
        $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

        try{
            if ($plan) {
                $get_amount = round($plan->price);

                if (!empty($request->coupon)) {
                    $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                    if (!empty($coupons)) {
                        $usedCoupun = $coupons->used_coupon();
                        $discount_value = ($plan->price / 100) * $coupons->discount;
                        $get_amount = $plan->price - $discount_value;

                        // Convert get_amount to an integer without cents
                        $get_amount = intval($get_amount);

                        $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                        $userCoupon = new UserCoupon();
                        $userCoupon->user = Auth::user()->id;
                        $userCoupon->coupon = $coupons->id;
                        $userCoupon->order = $orderID;
                        $userCoupon->save();

                        if ($coupons->limit == $usedCoupun) {
                            return redirect()->back()->with('error', __('This coupon code has expired.'));
                        }
                    } else {
                        return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                    }
                }
                // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = $midtrans_secret;

                if($midtrans_mode == 'sandbox')
                {
                     // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                    \Midtrans\Config::$isProduction = false;
                }
                else{
                    \Midtrans\Config::$isProduction = false;

                }

                // Set sanitization on (default)
                \Midtrans\Config::$isSanitized = true;
                // Set 3DS transaction for credit card to true
                \Midtrans\Config::$is3ds = true;

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $orderID,
                        'gross_amount' => $get_amount,
                    ),
                    'customer_details' => array(
                        'first_name' => Auth::user()->name,
                        'last_name' => '',
                        'email' => \Auth::user()->email,
                        'phone' => '8787878787',
                    ),
                );


                $snapToken = \Midtrans\Snap::getSnapToken($params);


                $authuser = \Auth::user();
                $authuser->plan = $plan->id;
                $authuser->save();

                Order::create(
                    [
                        'order_id' => $orderID,
                        'name' => null,
                        'email' => null,
                        'card_number' => null,
                        'card_exp_month' => null,
                        'card_exp_year' => null,
                        'plan_name' => $plan->name,
                        'plan_id' => $plan->id,
                        'price' => $get_amount == null ? 0 : $get_amount,
                        'price_currency' => $currency,
                        'txn_id' => '',
                        'payment_type' => __('Midtrans'),
                        'payment_status' => 'Success',
                        'receipt' => null,
                        'user_id' => $authuser->id,
                    ]
                );
                $data = [
                    'snap_token' => $snapToken,
                    'midtrans_secret' => $midtrans_secret,
                    'order_id' => $orderID,
                    'plan_id' => $plan->id,
                    'amount' => $get_amount,
                    'fallback_url' => 'plan.get.midtrans.status'
                ];

                return view('midtras.payment', compact('data'));
            }
        }catch (\Exception $e) {

            return redirect()->route('plan.index')->with('errors', $e->getMessage());
        }

    }

    public function planGetMidtransStatus(Request $request)
    {
        $response = json_decode($request->json, true);
        // dd($response);
        if (isset($response['status_code']) && $response['status_code'] == 200) {
            $plan = Plan::find($request['plan_id']);
            $user =  \Auth::user();
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            try {
                $Order                 = Order::where('order_id', $request['order_id'])->first();
                $Order->payment_status = 'succeeded';
                $Order->save();

                $assignPlan = $user->assignPlan($plan->id);

                if (!empty($request->coupon_id)) {
                    if (!empty($coupons)) {
                        $userCoupon = new UserCoupon();
                        $userCoupon->user = $user->id;
                        $userCoupon->coupon = $coupons->id;
                        $userCoupon->order = $orderID;
                        $userCoupon->save();
                        $usedCoupun = $coupons->used_coupon();
                        if ($coupons->limit <= $usedCoupun) {
                            $coupons->is_active = 0;
                            $coupons->save();
                        }
                    }
                }

                if ($assignPlan['is_success']) {
                    Utility::referraltransaction($plan);
                    return redirect()->route('plan.index')->with('success', __('Plan activated Successfully.'));
                } else {
                    return redirect()->route('plan.index')->with('error', __($assignPlan['error']));
                }
            } catch (\Exception $e) {
                return redirect()->route('plan.index')->with('error', __($e->getMessage()));
            }
        } else {
            if (isset($response['status_message'])) {
                $statusMessage = $response['status_message'];
            } else {
                $statusMessage = 'Default Message';
            }

            return redirect()->back()->with('error', $statusMessage);


            // return redirect()->back()->with('error', 'Please Enter  Valid Shop Id Key');

        }

    }
}
