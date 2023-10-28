<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
//    public function paypalProcess(Enrollment $retakenEnrollment) {
//        dd($retakenEnrollment);
//        // Payment method: PayPal
//        if ($retakenEnrollment->Exam->retaken_fee > 0 && !$retakenEnrollment->is_paid) {
//            $provider = new PayPalClient;
//            $provider->setApiCredentials(config('paypal'));
//            $paypalToken = $provider->getAccessToken();
//
//            $response = $provider->createEnrollment([
//                "intent" => "CAPTURE",
//                "application_context" => [
//                    "return_url" => url("paypal-success",['retakenEnrollment'=>$retakenEnrollment]),
//                    "cancel_url" => url("paypal-cancel"),
//                ],
//                "purchase_units" => [
//                    0 => [
//                        "amount" => [
//                            "currency_code" => "USD",
//                            "value" => number_format($retakenEnrollment->Exam->retaken_fee,2,".","") // 1234.45
//                        ]
//                    ]
//                ]
//            ]);
//
//            if (isset($response['id']) && $response['id'] != null) {
//
//                // redirect to approve href
//                foreach ($response['links'] as $links) {
//                    if ($links['rel'] == 'approve') {
//                        return redirect()->away($links['href']);
//                    }
//                }
//
//                return redirect()
//                    ->back()
//                    ->with('error', 'Something went wrong.');
//
//            } else {
//                return redirect()
//                    ->back()
//                    ->with('error', $response['message'] ?? 'Something went wrong.');
//            }
//        }
//    }
    public function paypalSuccess(Enrollment $retakenEnrollment, Request $request) {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $retakenEnrollment->update([
                "is_paid"=> true,
            ]); // Cập nhật trạng thái đã trả tiền
            return redirect()->to("thank-you") ///$retakenEnrollment->id
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->back()
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paypalCancel() {
        return redirect()->back()
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');;
    }
}
