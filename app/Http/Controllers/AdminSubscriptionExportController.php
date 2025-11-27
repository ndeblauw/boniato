<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class AdminSubscriptionExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $subscriptions = Subscription::all();

        $emails = $subscriptions->map(fn($s) => $s->email_for_export());

        return $emails;
    }
}
