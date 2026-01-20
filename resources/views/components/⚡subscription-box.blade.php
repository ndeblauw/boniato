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
    <div class="border-4 border-purple-600 bg-white text-black p-6">

        @if($message)
            <div class="mb-4 text-purple-600 text-sm">{{ $message }}</div>
        @else
            <form wire:submit="addToMailinglist()" class="flex justify-between items-center">
                Email:
                <input wire:model="email" type="text" name="email" class="border-2 border-black"/>
                @error('email')
                <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
                <button type="submit" class="bg-purple-600 text-white px-4 py-3 font-medium">Subscribe</button>
            </form>
        @endif

    </div>
</div>
