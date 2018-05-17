<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request) {

        try {

            \Stripe\Stripe::setApiKey("sk_test_1gvIbxUrEaKHLNmui1jtd0UO");

            // $plan = \Stripe\Plan::create([
            //   'product' => 'prod_CjDpZzpRCBRisp',
            //   'nickname' => 'Growth plan',
            //   'interval' => 'day',
            //   'currency' => 'USD',
            //   'amount' => 9900,
            // ]);

            $customer = \Stripe\Customer::create([
                'email' => $request->email,
                'source' => $request->stripeToken,
                'description' => 'sample description',
            ]);

            $subscription = \Stripe\Subscription::create([
                'customer' => $customer,
                'items' => [['plan' => 'enterprise_daily']],
            ]);


            // $charge = Stripe::charges()->create([
            //     'currency' => 'USD',
            //     'amount'   => 99,
            //     'source' => $request->stripeToken,
            //     'description' => 'sample description',
            //     'receipt_email' => $request->email,
            //     'metadata' => [
            //         'data1' => 'metadata1',
            //         'data2' => 'metadata2',
            //         'data3' => 'metadata3',
            //     ]
            // ]);

            //SUCCESSFUL
            return back()->with('success_message', 'Payment successful');
            
        } catch (CardErrorException $e) {
            return back()->withErrors($e->getMessage());
        } catch (\Stripe\Error\Card $e) {
            return back()->withErrors($e->getMessage());
        } catch (\Stripe\Error\InvalidRequest $e) {
            return back()->withErrors($e->getMessage());
        } catch (\Stripe\Error\Authentication $e) {
            return back()->withErrors($e->getMessage());
        } catch (\Stripe\Error\Base $e) {
            return back()->withErrors($e->getMessage());
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
