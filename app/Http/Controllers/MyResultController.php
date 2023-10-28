<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Order;
use App\Models\Product;
use App\Models\Question;
use App\Models\EnrollmentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class MyResultController extends Controller
{
    public function myResult() {
        try{
            $total_score = 0;

            $student = auth()->user();
            $enrollments = Enrollment::where('student_id', '=', $student->id)
                ->where("status", Enrollment::COMPLETED)
                ->orderBy("updated_at", "desc")
                ->get();

            $enrollment_results = null;
            foreach ($enrollments as $enrollment) {
                $enrollment_results = EnrollmentResult::where("enrollment_id", $enrollment->id)
                    ->orderBy("id", "desc")
                    ->get();
            }

            return view("pages.result.my-result",
                compact("enrollments", "enrollment_results", "total_score"));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examRetaken(Exam $exam) {
        try{
            $student = auth()->user();
            $enrollment = Enrollment::where('student_id', $student->id)
                ->where("exam_id", $exam->id)
                ->orderBy("id", "desc")
                ->first();

            // Update status to retaken
            $enrollment->update([
                "status", Enrollment::RETAKEN
            ]);

            // Create new enrollment with attempt = 2
            $retakenEnrollmentId = Enrollment::insertGetId([
                'student_id' => $student->id,
                'exam_id' => $exam->id,
                'status' => Enrollment::PENDING,
                'attempt' => $enrollment->attempt + 1,
                'is_paid' => false
            ]);

            $retakenEnrollment = Enrollment::find($retakenEnrollmentId);
            // Payment method: PayPal
            if ($retakenEnrollment->Exam->retaken_fee > 0 && !$retakenEnrollment->is_paid) {
                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $paypalToken = $provider->getAccessToken();

                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => url("paypal-success", "retakenEnrollment",$retakenEnrollment),
                        "cancel_url" => url("paypal-cancel"),
                    ],
                    "purchase_units" => [
                        0 => [
                            "amount" => [
                                "currency_code" => "USD",
                                "value" => number_format($retakenEnrollment->Exam->retaken_fee,2,".","") // 1234.45
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
            return redirect()->back()->with("retaken", "You have been retaken $exam->exam_name. We'll send you an email when your exam get started!");
//            // Go to Paypal
//            return redirect()->to("paypal-process/$retakenEnrollmentId");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function thankYou() {
        return view("pages.result.thank-you");
    }
}
