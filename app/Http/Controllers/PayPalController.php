<?php

namespace App\Http\Controllers;

use App\Events\CreateNewOrder;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function paypalProcess(Order $order) {
        // Payment method: Paypal
        if ($order->payment_method == "paypal") {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => url("paypal-success",['order'=>$order]),
                    "cancel_url" => url("paypal-cancel"),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => number_format($order->grand_total,2,".","") // 1234.45
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {

                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }

                return redirect()
                    ->back()
                    ->with('error', 'Something went wrong.');

            } else {
                return redirect()
                    ->back()
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        }
    }
    public function paypalSuccess(Order $order, Request $request) {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $order->update([
                "is_paid"=> true,
                "status"=> Order::CONFIRMED,
            ]); // Cập nhật trạng thái đã trả tiền
            return redirect()->to("thank-you/$order->id")
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->back()
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
//        global $email;
//        $order->update([
//            "is_paid"=> true,
//            "status"=> Order::CONFIRMED,
//        ]); // Cập nhật trạng thái đã trả tiền
//        return redirect()->to("thank-you/$order->id")
////                ->with('success', 'Transaction complete.');
//            ->with('email', $email);
    }

    public function paypalCancel() {
        return redirect()->back()
                        ->with('error', $response['message'] ?? 'You have canceled the transaction.');;
    }
}
