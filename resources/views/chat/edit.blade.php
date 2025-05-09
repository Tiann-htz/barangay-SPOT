<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Message') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('chat.messages.update', $chatMessage) }}">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input-label for="message" :value="__('Message')" />
                            <textarea id="message" name="message" rows="4" 
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('message', $chatMessage->message) }}</textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button onclick="window.history.back()" class="me-3" type="button">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button class="ms-3">
                                {{ __('Update Message') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>