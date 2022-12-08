<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaypalController extends Controller
{
    //
    public function index(){
        return view('products.welcome');
    }
    public function payment(){
        $data =[];
        $data['items'] = [
            [
                'name'=>'chips',
                'price'=>10,
                'desc'=>'chips potato',
                'qty'=>3,
            ], [
                'name'=>'Apple',
                'price'=>100,
                'desc'=>'Mackbook pro 14 inch',
                'qty'=>1
            ]
        ];
        $data['invoice_id'] ="PAYPALDEMOAPP_V432_54" ;
        $data['invoice_description'] = "order #{$data['invoice_id']} invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] =130;
        $provider = new ExpressCheckout;
        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data,true);
       // dd($response);
        return redirect($response['paypal_link']);
    }

    public function cancel(){
        dd('u canceld the payment');
    }
    public function success(Request $request){
        $provider = new ExpressCheckout();
        $response = $provider->getExpressCheckoutDetails($request->token);
       // dd($response);
        if (in_array(strtoupper($response['ACK']),['SUCCESS','SUCCESSWITHWARNINIG'])){
            dd('ur payment successfully done.. thanks');
        }
        dd('please try again later');
    }
}
