<?php

use App\Models\Subscription;

it('exports all subscription emails', function () {
    $subscriptions = Subscription::factory()->count(3)->create();

    $response = $this->get('/admin/subscriptions/export');

    $response->assertSuccessful();
    $emails = $response->json();
    
    expect($emails)->toHaveCount(3);
    foreach ($subscriptions as $subscription) {
        expect($emails)->toContain($subscription->email_for_export());
    }
});

it('exports empty subscription list', function () {
    $response = $this->get('/admin/subscriptions/export');

    $response->assertSuccessful();
    $emails = $response->json();
    
    expect($emails)->toBeArray();
    expect($emails)->toHaveCount(0);
});

it('exports subscriptions with different email formats', function () {
    $subscription1 = Subscription::factory()->create(['email' => 'test1@example.com']);
    $subscription2 = Subscription::factory()->create(['email' => 'test2@example.org']);
    $subscription3 = Subscription::factory()->create(['email' => 'test3@example.net']);

    $response = $this->get('/admin/subscriptions/export');

    $response->assertSuccessful();
    $emails = $response->json();
    
    expect($emails)->toHaveCount(3);
    expect($emails)->toContain($subscription1->email_for_export());
    expect($emails)->toContain($subscription2->email_for_export());
    expect($emails)->toContain($subscription3->email_for_export());
});

it('exports subscriptions as json response', function () {
    Subscription::factory()->count(2)->create();

    $response = $this->get('/admin/subscriptions/export');

    $response->assertSuccessful()
        ->assertJsonCount(2);
});

it('handles single subscription', function () {
    $subscription = Subscription::factory()->create();

    $response = $this->get('/admin/subscriptions/export');

    $response->assertSuccessful();
    $emails = $response->json();
    
    expect($emails)->toHaveCount(1);
    expect($emails[0])->toBe($subscription->email_for_export());
});

it('returns array of strings', function () {
    Subscription::factory()->count(3)->create();

    $response = $this->get('/admin/subscriptions/export');

    $response->assertSuccessful();
    $emails = $response->json();
    
    foreach ($emails as $email) {
        expect($email)->toBeString();
    }
});