<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();
        if($user) {
            Subscription::create([
                'user_id' => $user->id,
            ]);
        } else {
            Subscription::create([
                'email' => $validated['email'],
            ]);
        }

        return redirect()->back();
    }
}
