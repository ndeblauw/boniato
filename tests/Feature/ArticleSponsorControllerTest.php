<?php

use App\Models\User;
use App\Models\Article;
use App\Models\Purchase;
use Mollie\Laravel\Facades\Mollie;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Resources\Payment;

it('prepares payment for article sponsorship', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();
    
    $mockPayment = new class extends Payment {
        public function getCheckoutUrl() {
            return 'https://checkout.mollie.com/test';
        }
        public function getId() {
            return 'test_payment_id';
        }
    };
    
    Mollie::shouldReceive('send')->andReturn($mockPayment);

    $response = $this->actingAs($user)->post("/articles/{$article->id}/sponsor", [
        'amount' => 10.50,
    ]);

    $response->assertRedirect('https://checkout.mollie.com/test', 303);
    
    $this->assertDatabaseHas('purchases', [
        'user_id' => $user->id,
        'article_id' => $article->id,
        'amount_cents' => 1050,
        'mollie_payment_id' => 'test_payment_id',
    ]);
});

it('creates purchase with correct amount in cents', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();
    
    $mockPayment = new class extends Payment {
        public function getCheckoutUrl() { return 'https://checkout.mollie.com/test'; }
        public function getId() { return 'test_payment_id'; }
    };
    
    Mollie::shouldReceive('send')->andReturn($mockPayment);

    $this->actingAs($user)->post("/articles/{$article->id}/sponsor", [
        'amount' => 25.75,
    ]);

    $this->assertDatabaseHas('purchases', [
        'user_id' => $user->id,
        'article_id' => $article->id,
        'amount_cents' => 2575,
    ]);
});

it('requires authentication', function () {
    $article = Article::factory()->create();

    $response = $this->post("/articles/{$article->id}/sponsor", [
        'amount' => 10.00,
    ]);

    $response->assertRedirect('/login');
});

it('handles zero amount', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();
    
    $mockPayment = new class extends Payment {
        public function getCheckoutUrl() { return 'https://checkout.mollie.com/test'; }
        public function getId() { return 'test_payment_id'; }
    };
    
    Mollie::shouldReceive('send')->andReturn($mockPayment);

    $this->actingAs($user)->post("/articles/{$article->id}/sponsor", [
        'amount' => 0,
    ]);

    $this->assertDatabaseHas('purchases', [
        'user_id' => $user->id,
        'article_id' => $article->id,
        'amount_cents' => 0,
    ]);
});

it('handles decimal amounts correctly', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();
    
    $mockPayment = new class extends Payment {
        public function getCheckoutUrl() { return 'https://checkout.mollie.com/test'; }
        public function getId() { return 'test_payment_id'; }
    };
    
    Mollie::shouldReceive('send')->andReturn($mockPayment);

    $this->actingAs($user)->post("/articles/{$article->id}/sponsor", [
        'amount' => 99.99,
    ]);

    $this->assertDatabaseHas('purchases', [
        'user_id' => $user->id,
        'article_id' => $article->id,
        'amount_cents' => 9999,
    ]);
});

it('creates mollie payment with correct metadata', function () {
    $user = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    $article = Article::factory()->create(['title' => 'Test Article']);
    
    $mockPayment = new class extends Payment {
        public function getCheckoutUrl() { return 'https://checkout.mollie.com/test'; }
        public function getId() { return 'test_payment_id'; }
    };
    
    Mollie::shouldReceive('send')->withArgs(function ($request) use ($user, $article) {
        $metadata = $request->metadata;
        return $metadata['customer_info']['user_id'] === $user->id &&
               $metadata['customer_info']['name'] === $user->name &&
               $metadata['customer_info']['email'] === $user->email &&
               $metadata['article_id'] === $article->id;
    })->andReturn($mockPayment);

    $this->actingAs($user)->post("/articles/{$article->id}/sponsor", [
        'amount' => 10.00,
    ]);
});

it('creates mollie payment with correct description', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create(['title' => 'Test Article']);
    $author = User::factory()->create(['name' => 'Jane Smith']);
    $article->author()->associate($author);
    $article->save();
    
    $mockPayment = new class extends Payment {
        public function getCheckoutUrl() { return 'https://checkout.mollie.com/test'; }
        public function getId() { return 'test_payment_id'; }
    };
    
    Mollie::shouldReceive('send')->withArgs(function ($request) {
        return $request->description === 'Sponsoring article: Test Article by Jane Smith';
    })->andReturn($mockPayment);

    $this->actingAs($user)->post("/articles/{$article->id}/sponsor", [
        'amount' => 10.00,
    ]);
});

it('creates mollie payment with correct amount format', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();
    
    $mockPayment = new class extends Payment {
        public function getCheckoutUrl() { return 'https://checkout.mollie.com/test'; }
        public function getId() { return 'test_payment_id'; }
    };
    
    Mollie::shouldReceive('send')->withArgs(function ($request) {
        return $request->amount->currency === 'EUR' &&
               $request->amount->value === '10.50';
    })->andReturn($mockPayment);

    $this->actingAs($user)->post("/articles/{$article->id}/sponsor", [
        'amount' => 10.50,
    ]);
});

it('updates purchase with mollie payment id', function () {
    $user = User::factory()->create();
    $article = Article::factory()->create();
    
    $mockPayment = new class extends Payment {
        public function getCheckoutUrl() { return 'https://checkout.mollie.com/test'; }
        public function getId() { return 'mollie_payment_123'; }
    };
    
    Mollie::shouldReceive('send')->andReturn($mockPayment);

    $this->actingAs($user)->post("/articles/{$article->id}/sponsor", [
        'amount' => 10.00,
    ]);

    $purchase = Purchase::where('user_id', $user->id)
        ->where('article_id', $article->id)
        ->first();
    
    expect($purchase->mollie_payment_id)->toBe('mollie_payment_123');
});