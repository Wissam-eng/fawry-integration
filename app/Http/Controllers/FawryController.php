<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FawryService;

class FawryController extends Controller
{
    protected $fawryService;

    public function __construct(FawryService $fawryService)
    {
        $this->fawryService = $fawryService;
    }

    /**
     * صفحة تنفيذ الدفع
     */
    public function pay()
    {
        $customerMobile = "01000000000"; // مثال رقم الهاتف
        $amount = 100; // مثال للمبلغ بالجنيه المصري

        $paymentLink = $this->fawryService->createPayment($customerMobile, $amount);
        
        if ($paymentLink) {
            return redirect($paymentLink); // توجيه المستخدم إلى صفحة الدفع
        }

        return back()->with('error', 'حدث خطأ أثناء إنشاء رابط الدفع.');
    }

    /**
     * استلام رد الدفع بعد إتمام العملية
     */
    public function callback(Request $request)
    {
        $status = $request->input('status');
        $merchantRefNum = $request->input('merchantRefNum');

        if ($status == "PAID") {
            return "تم الدفع بنجاح. الرقم المرجعي: " . $merchantRefNum;
        } else {
            return "فشلت عملية الدفع.";
        }
    }
}
