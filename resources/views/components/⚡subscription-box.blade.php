<?php

use App\Models\Subscription;
use App\Models\User;
use Livewire\Component;

new class extends Component {
    public string $email = '';
    public ?string $message = null;

    public function addToMailinglist()
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        $this->makeSubscription();

        $this->email = '';
        $this->message = "You have been subscribed to the mailing list. Thank you!";
    }

    private function makeSubscription(): void
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            Subscription::create([
                'user_id' => $user->id,
            ]);
        } else {
            Subscription::create([
                'email' => $this->email,
            ]);
        }
    }

};
?>

<div class="mx-auto w-4/5 mt-8">
    <div class="border-2 border-pink-500 bg-pink-50 text-pink-500 p-6 rounded-lg">

        @if($message)
            <div class="mb-4 text-green-500 text-sm">{{ $message }}</div>
        @else
            <form wire:submit="addToMailinglist()" class="flex justify-between items-center">
                Email:
                <input wire:model="email" type="text" name="email" class="border border-pink-500"/>
                @error('email')
                <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
                <button type="submit" class="bg-pink-500 text-white px-4 py-3 rounded font-medium">Subscribe</button>
            </form>
        @endif

    </div>
</div>
