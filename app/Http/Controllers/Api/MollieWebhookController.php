<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Mollie\Api\Http\Requests\GetPaymentRequest;
use Mollie\Laravel\Facades\Mollie;

class MollieWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $mollie_payment_id = $request->id;

        $my_payment = Purchase::where('mollie_payment_id', $mollie_payment_id)->first();

        $payment = Mollie::send(new GetPaymentRequest($mollie_payment_id));

        if ($payment->isPaid())
        {
            $my_payment->update(['status' => 'paid']);
        }

        ray($payment)->label('Mollie Webhook Payload')->purple();
    }
}
