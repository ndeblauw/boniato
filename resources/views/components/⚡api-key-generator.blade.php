<?php

use Livewire\Component;

new class extends Component
{
    public string $apiKeyName = '';
    public string $newToken = '';


    public function generateApiKey()
    {
        $user = auth()->user();

        $data = $user->createToken($this->apiKeyName ?? 'Default API Key');

        $this->newToken = $data->plainTextToken;

        $this->apiKeyName = '';
    }
};
?>

<div class="p-6 bg-white border-b border-t border-purple-500 mt-6">

    @if($newToken)
        <div class="bg-green-200 border border-green-400 text-green-800 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">New API Key Generated!</strong>
            <span class="block sm:inline">Please copy and store this API key securely. You won't be able to see it again.</span>
            <div class="mt-2 p-2 bg-gray-100 border border-gray-300 rounded">
                <code class="break-all">{{ $newToken }}</code>
            </div>
        </div>
    @endif

    <div class="flex flex-row gap-4 justify-between items-center">
        <input type="text" name="api_key_name" placeholder="Enter API Key Name" wire:model="apiKeyName"
               class="w-2/3 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
        >
        <button
            wire:click="generateApiKey()"
            class="px-4 w-1/3 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50">
            Generate API Key
        </button>
    </div>

    @foreach(auth()->user()->tokens as $token)
        <div class="mt-4 p-1 bg-gray-100 border border-gray-300 rounded flex justify-between items-center">
            <div>
                <strong>{{ $token->name }}</strong>
                <p class="text-sm text-gray-600">Created at: {{ $token->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <form>
                <button
                    type="submit"
                    class="px-4 py-0.5 bg-sky-600 text-white rounded hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-opacity-50">
                    Revoke
                </button>
            </form>
        </div>
    @endforeach




</div>
