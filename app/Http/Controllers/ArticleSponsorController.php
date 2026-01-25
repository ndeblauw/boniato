<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Purchase;
use Mollie\Api\Http\Data\Money;
use Mollie\Api\Http\Requests\CreatePaymentRequest;
use Mollie\Laravel\Facades\Mollie;

class ArticleSponsorController extends Controller
{
    public function preparePayment(Article $article)
    {

        $amount_cents = request()->amount * 100;

        $webhook_url = route('api.mollie.webhook');
        $webhook_url = 'https://6yex821lsn.sharedwithexpose.com/api/mollie/webhook';

        $user = auth()->user();

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'amount_cents' => $amount_cents,
        ]);

        $request = new CreatePaymentRequest(
            description: 'Sponsoring article: '.$article->title.' by '.$article->author->name,
            amount: new Money('EUR', number_format($amount_cents / 100, 2, '.', '')),
            redirectUrl: route('articles.show', ['article' => $article->id, 'purchase' => $purchase->id]),
            webhookUrl: $webhook_url,
            metadata: [
                'order_id' => "# $purchase->id",
                'article_id' => $article->id,
                'customer_info' => [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]
        );

        $payment = Mollie::send($request);

        $purchase->update([
            'mollie_payment_id' => $payment->id,
        ]);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }
    //
}
