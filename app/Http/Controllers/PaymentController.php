<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmed;
use App\Models\Capacity;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\PaymentConfirmation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tarsoft\Toyyibpay\Toyyibpay;

class PaymentController extends Controller
{
    public function createBill($orderid)
    {
        $order = Order::find($orderid);

        $ref_id = $order->ref_id;
        $cust_name = $order->customer->name;
        $cust_phone = $order->customer->phone_no;
        $cust_email = $order->customer->email;
        $total_payment = $order->total * 100;
        $bill_name = 'Buffet Ramadan ' . $order->capacity->venue->name;
        $bill_desc = 'Tarikh booking: ' . Carbon::parse($order->capacity->venue_date)->locale('ms_MY')->format('d M Y');
        $option = array(
            'userSecretKey' => config('toyyibpay.key'),
            'categoryCode' => config('toyyibpay.category'),
            'billName' => $bill_name,
            'billDescription' => $bill_desc,
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $total_payment, //100 = RM1
            'billReturnUrl' => route('payment.paymentStatus'), //URL Status kita
            'billCallbackUrl' => route('payment.callback'),
            'billExternalReferenceNo' => $ref_id, //REFID system sendiri
            'billTo' => $cust_name,
            'billEmail' => $cust_email,
            'billPhone' => $cust_phone,
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => 0,
            'enableFPXB2B' => 1,
            'chargeFPXB2B' => 1,
            // 'billContentEmail' => 'Terima kasih! Selamat berpuasa :D',
            'billChargeToCustomer' => '',
        );

        if (App::isLocal()) {
            $domain = 'https://dev.toyyibpay.com/';
        } else {
            $domain = 'https://toyyibpay.com/';
        }
        $url = $domain . 'index.php/api/createBill';

        $response = Http::asForm()->post($url, $option);
        if (!empty($response) && isset($response[0]['BillCode'])) {
            $billCode = $response[0]['BillCode'];
            return redirect($domain . $billCode);
        } else {
            return back()->withErrors(['payment_failed' => 'Bayaran tidak dapat diproses. Sila cuba lagi.'])->withInput();
        }
    }

    public function paymentStatus()
    {
        $response = request()->all(['status_id', 'billcode', 'order_id']);
        $status_id = $response['status_id'];
        $billcode = $response['billcode'];
        $ref_id = $response['order_id'];

        /**
         * status_id -> 1= success, 2=pending, 3=fail (from API)
         * billcode -> fpx_id
         */

        $order = Order::where('ref_id', $ref_id)->first();
        $order->fpx_id = $billcode;

        switch ($status_id) {
            case '1':
                $order->status = 2;
                break;
            case '3':
                $order->status = 4;
                break;
            default:
                $order->status = 4;
                break;
        }
        $order->save();

        if ($status_id == 1) {
            return redirect()->route('form.completed', $order);
        } else {
            return redirect()->route('form.failed');
        }
    }

    public function callback()
    {
        $response = request()->all(['refno', 'status', 'reason', 'billcode', 'order_id', 'amount']);

        // Log::info($response);

        $refno = $response['refno'] ?? null;
        $status = $response['status'] ?? null;
        $reason = $response['reason'] ?? null;
        $billcode = $response['billcode'] ?? null;
        $order_ref_id = $response['order_id'] ?? null;
        $amount = $response['amount'] ?? null;

        if ($order_ref_id) {
            // Find the order by reference ID
            $order = Order::where('ref_id', $order_ref_id)->first();

            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }

            $order_id = $order->id;

            // Create a payment confirmation record
            $payment_confirmation = PaymentConfirmation::create([
                'order_id' => $order_id,
                'ref_no' => $refno,
                'status' => $status,
                'reason' => $reason,
                'bill_code' => $billcode,
                'amount' => $amount,
            ]);

            if ($payment_confirmation) {
                $order = Order::find($payment_confirmation->order_id);
                $order->fpx_id = $payment_confirmation->bill_code;
                switch ($status) {
                    case '1':
                        $order->status = 2;
                        break;
                    case '3':
                        $order->status = 4;
                        break;
                    default:
                        $order->status = 4;
                        break;
                }
                $order->save();

                if ($status == 1) {

                    $order_details = OrderDetails::where('order_id', $order->id)->get();
                    $total_quantity = $order_details->sum('quantity');

                    $capacity = Capacity::find($order->venue_id);
                    $new_tpaid = $capacity->total_paid + $total_quantity;
                    $new_tcap = $capacity->available_capacity - $new_tpaid;
                    $capacity->total_paid = $new_tpaid;
                    $capacity->available_capacity = $new_tcap;
                    /**
                     * status = 1 ; available
                     * 2 = warning
                     * 3 = sold out
                     */

                    $new_tcap < 20 ?? $capacity->status = 2;
                    $new_tcap == 0 ?? $capacity->status = 3;
                    $capacity->save();
                }
            }
        }

        return response()->json(['error' => 'Order ID not provided'], 400);
    }
}
