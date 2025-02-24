<?php

namespace App\Http\Controllers;

// use App\Models\FawryPay;
use Illuminate\Http\Request;
use MTGofa\FawryPay\FawryPay;


class FawryPayController extends Controller
{



    public function generate()
    {

        dd('test');
        $fawryPay = new FawryPay;

        //optional if you have the customer data
        $fawryPay->customer([
            'customerProfileId' => '1',
            'name'              => 'Mohamed Tarek',
            'email'             => 'example@site.com',
            'mobile'            => '010******',
        ]);

        //you can add this method info foreach if you have multible items
        $fawryPay->addItem([
            'productSKU'    => '1', //item id
            'description'   => 'Order 100001 Invoice', //item name
            'price'         => '50.00', //item price
            'quantity'      => '1', //item quantity
        ]);

        //generatePayURL('your order unique id','your order discription','success url','failed url')
        $pay_url = $fawryPay->generatePayURL('100001', 'Order 100001 Invoice', 'http://success_url', 'http://failed_url');
        return redirect($pay_url);
    }

    public function callback()
    {

        $ref_id = NULL;
        if (request('merchantRefNum')) { //fawry failed
            $ref_id = request('merchantRefNum');
        } elseif (request('MerchantRefNo')) { //fawry ipn
            $ref_id = request('MerchantRefNo');
        } elseif (request('chargeResponse')) { //fawry response is success
            $chargeResponse = json_decode(request('chargeResponse'));
            $ref_id = isset($chargeResponse->merchantRefNumber) ? $chargeResponse->merchantRefNumber : NULL;
        }

        if (!$ref_id) return abort('404');

        $response = (new FawryPay)->checkStatus($ref_id);
        if (isset($response->paymentStatus) and $response->paymentStatus == 'PAID') { //paid
            dd('Paid Successfully', $response);
        } else {
            dd($response);
        }
    }
}
