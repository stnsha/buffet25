<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tarsoft\Toyyibpay\Toyyibpay;

class PaymentController extends Controller
{
    public function createBill()
    {
        $option = array(
            'userSecretKey' => config('toyyibpay.key'),
            'categoryCode' => config('toyyibpay.category'),
            'billName' => 'Car Rental WXX123',
            'billDescription' => 'Car Rental WXX123 On Sunday',
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => 100, //100 = RM1
            'billReturnUrl' => route('payment.paymentStatus'), //URL Status kita
            'billCallbackUrl' => route('payment.callback'),
            'billExternalReferenceNo' => 'ARN123', //REFID system sendiri
            'billTo' => 'Siti Anasuha',
            'billEmail' => 'anasuharosli@gmail.com',
            'billPhone' => '01156403061',
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => 0,
            'billContentEmail' => 'Thank you for purchasing our product!',
            'billChargeToCustomer' => '',
            // 'billExpiryDate' => '17-12-2020 17:00:00',
            // 'billExpiryDays' => 3
        );

        $url = 'https://dev.toyyibpay.com/index.php/api/createBill';

        $response = Http::asForm()->post($url, $option);
        $billCode = $response[0]['BillCode'];
        return redirect('https://dev.toyyibpay.com/' . $billCode);
    }

    public function paymentStatus()
    {
        $response = request()->all(['status_id', 'billcode', 'order_id']);

        return $response;
    }

    public function callback()
    {
        Log::info('from callabck function');
        $response = request()->all(['refno', 'status', 'reason', 'billcode', 'order_id', 'amount']);

        Log::info($response);
    }
}