<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FawryService
{
    private $merchantCode;
    private $securityKey;
    private $apiUrl;

    public function __construct()
    {
        $this->merchantCode = env('FAWRY_MERCHANT_CODE');
        $this->securityKey = env('FAWRY_SECRET_KEY');
        $this->apiUrl = env('FAWRY_API_URL');
    }

    /**
     * إنشاء طلب دفع عبر فوري
     */
    public function createPayment($customerMobile, $amount)
    {


        // $customerMobile = "01000000000"; // مثال رقم الهاتف
        // $amount = 100;

        $merchantRefNum = uniqid(); // رقم مرجعي فريد للطلب
        $currency = "EGP"; // الجنيه المصري
        // $returnUrl = route('fawry.callback');
        $returnUrl = 'https://highleveltecknology.com/beehive/callback';


        // إنشاء التوقيع (Signature)
        $signatureString = $this->merchantCode . $merchantRefNum . ""  . $returnUrl . '6b5fdea340e31b3b0339d4d4ae5' . $amount . '50.00' . $this->securityKey;
        $signature = hash('sha256', $signatureString);

        // تجهيز بيانات الطلب
        $data = [
            "merchantCode" => $this->merchantCode,
            "merchantRefNum" => $merchantRefNum,
            "customerMobile" => $customerMobile,
            "language" => "en-gb",
            // "amount" => $amount,
            // "currency" => $currency,
            "chargeItems" => [
                [
                    "itemId" => '6b5fdea340e31b3b0339d4d4ae5',
                    "price" => 50.00,
                    "quantity" => $amount
                ]
            ],
            "governorate" => "GIZA",
            "city" => "MOHANDESSIN",
            "area" => "GAMETDEWAL",
            "address" => "9th 90 Street, apartment number 8, 4th floor",
            "receiverName" => "Receiver Name",
            "returnUrl" => $returnUrl,
            "signature" => $signature,
        ];

        // dd($data);


        // إرسال الطلب إلى API فوري
        $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($this->apiUrl, $data);
        // dd($response);
        $result = $response->json();


        // dd($response->body());

        if ($response->successful()) {
            // return $result;
            if ($response->body()) {

                return $response->body(); // إرجاع رابط الدفع للعميل
            }
        } else {
            dd($result);
            return $result;
        }


        return null;
    }
}
