@extends('layouts.app')

@section('title', 'Vérification du paiement')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 py-12 flex items-center justify-center">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            @if($payment->isCompleted())
                <!-- Paiement réussi -->
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Paiement confirmé !</h1>
                <p class="text-gray-600 mb-2">Votre paiement de <span class="font-bold text-green-600">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</span> a été effectué avec succès.</p>
                <p class="text-sm text-gray-500 mb-8">Référence : {{ $payment->payment_reference }}</p>

                <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-8 text-left">
                    <p class="text-sm text-blue-800">
                        <strong>Important :</strong> Un email de confirmation a été envoyé à {{ $payment->user_email }}
                    </p>
                </div>

                <a href="{{ route('event.details', $eventSlug) }}" 
                   class="inline-block bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition">
                    Voir les détails de l'événement
                </a>

                <a href="{{ route('accueil') }}" 
                   class="block mt-4 text-gray-600 hover:text-gray-800">
                    Retour à l'accueil
                </a>
            @else
                <!-- Paiement en attente -->
                <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-16 h-16 text-yellow-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Paiement en cours...</h1>
                <p class="text-gray-600 mb-8">Veuillez patienter pendant que nous vérifions votre paiement.</p>

                <button onclick="location.reload()" 
                        class="bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition">
                    Actualiser
                </button>
            @endif
        </div>
    </div>
</div>
@endsection
