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
    <div class="bg-[repeating-linear-gradient(45deg,rgba(147,51,234,0.95)_0,rgba(147,51,234,0.95)_10px,transparent_10px,transparent_20px)] pl-4 pt-2">


        <div class="bg-purple-600 text-white p-6">

            @if($message)
                <div class="mb-4 text-white text-sm">{{ $message }}</div>
            @else
                <form wire:submit="addToMailinglist()" class="flex justify-between items-center gap-4">
                    <span class="font-semibold">Email:</span>
                    <input wire:model="email" type="text" name="email" class="flex-1 bg-white text-black px-3 py-2"/>
                    @error('email')
                    <div class="text-white text-sm">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="bg-black text-white px-6 py-2 font-medium hover:bg-purple-700">Subscribe</button>
                </form>
            @endif

        </div>
    </div>
</div>
