<?php

use App\Models\Subscription;
use App\Models\User;

test('returns all subscription emails', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    
    Subscription::factory()->count(3)->create([
        'email' => null,
        'user_id' => User::factory(),
    ]);

    $response = $this->actingAs($admin)->get(route('admin.subscriptions.export'));

    $response->assertStatus(200);
    $response->assertJsonCount(3);
});
