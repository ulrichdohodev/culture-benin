@extends('layouts.app')

@section('title', 'Paiement - ' . $event['title'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($hasPaid)
            <!-- Utilisateur a déjà payé -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Vous avez déjà accès à cet événement</h1>
                <p class="text-gray-600 mb-8">Votre paiement a été confirmé. Vous pouvez maintenant accéder aux détails complets.</p>
                <a href="{{ route('event.details', $event['slug']) }}" 
                   class="inline-block bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition">
                    Voir les détails
                </a>
            </div>
        @else
            <!-- Formulaire de paiement -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- En-tête avec image -->
                <div class="relative h-64">
                    <img src="{{ asset($event['img']) }}" alt="{{ $event['title'] }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <h1 class="text-4xl font-bold mb-2">{{ $event['title'] }}</h1>
                        <div class="flex items-center gap-4">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $event['date'] }}
                            </span>
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event['lieu'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contenu -->
                <div class="p-8">
                    <div class="mb-8">
                        <div class="bg-green-50 border-l-4 border-green-600 p-6 rounded-r-lg mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-green-800 mb-1">Prix d'accès</p>
                                    <p class="text-3xl font-bold text-green-600">{{ number_format($event['price'], 0, ',', ' ') }} FCFA</p>
                                </div>
                                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900 mb-4">À propos</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $event['description'] }}</p>
                    </div>

                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-600 p-4 mb-6 rounded-r-lg">
                            <p class="text-red-800">{{ session('error') }}</p>
                        </div>
                    @endif

                    <!-- Formulaire de paiement -->
                    <form action="{{ route('event.payment.process', $event['slug']) }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" id="email" required
                                   value="{{ Auth::check() ? Auth::user()->email : old('email') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="votre@email.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Numéro de téléphone *</label>
                            <input type="tel" name="phone" id="phone" required
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="+229 XX XX XX XX">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Moyen de paiement *</label>
                            <div class="grid grid-cols-1">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="kkiapay" required class="peer sr-only" checked>
                                    <div class="p-4 border-2 border-green-600 rounded-lg peer-checked:border-green-700 peer-checked:bg-green-50 transition bg-green-50">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-700 rounded-lg flex items-center justify-center font-bold text-white shadow-lg">
                                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <span class="font-bold text-gray-900 text-lg">KKiaPay</span>
                                                    <p class="text-xs text-gray-600">MTN, Moov, Carte bancaire</p>
                                                </div>
                                            </div>
                                            <span class="bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full">Unique</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ route('accueil') }}" 
                               class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition text-center">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                                Payer {{ number_format($event['price'], 0, ',', ' ') }} FCFA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
