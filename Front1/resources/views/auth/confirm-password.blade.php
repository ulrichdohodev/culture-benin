<x-guest-layout>
    <div class="text-center mb-6">
        <div class="mx-auto w-14 h-14 rounded-full flex items-center justify-center mb-3 overflow-hidden bg-white/10 shadow-sm">
            <img src="{{ asset('images/logo.png') }}" alt="Culture Bénin" class="w-full h-full object-cover">
        </div>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
