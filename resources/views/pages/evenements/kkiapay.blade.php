@extends('layouts.app')

@section('title', 'Paiement KKiaPay - ' . $event['title'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-green-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Paiement via KKiaPay</h1>
                <p class="text-gray-600">{{ $event['title'] }}</p>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-6 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-blue-800 font-semibold mb-1">Instructions de paiement</p>
                        <p class="text-sm text-blue-700">Cliquez sur le bouton ci-dessous pour procéder au paiement sécurisé avec KKiaPay. Vous pourrez payer avec MTN Mobile Money, Moov Money ou votre carte bancaire.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Montant à payer</span>
                    <span class="text-3xl font-bold text-green-600">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">Référence</span>
                    <span class="font-mono text-gray-900">{{ $payment->payment_reference }}</span>
                </div>
            </div>

            <div class="text-center">
                <!-- Bouton de paiement KKiaPay -->
                <button 
                    id="kkiapay-button"
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-4 rounded-lg font-bold text-lg hover:from-green-700 hover:to-green-800 transition shadow-lg flex items-center justify-center gap-3 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Payer avec KKiaPay</span>
                </button>

                <a href="{{ route('event.payment.show', $eventSlug) }}" 
                   class="text-gray-600 hover:text-gray-800 text-sm">
                    ← Retour au formulaire
                </a>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-center gap-6 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Paiement sécurisé</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Confirmation instantanée</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KKiaPay SDK -->
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser KKiaPay
        openKkiapayWidget({
            amount: {{ $payment->amount }},
            position: "center",
            callback: "{{ route('event.payment.kkiapay.callback') }}",
            data: JSON.stringify({
                payment_id: {{ $payment->id }},
                event_slug: "{{ $eventSlug }}"
            }),
            theme: "#15803d",
            key: "{{ env('KKIAPAY_PUBLIC_KEY', 'pk_test_xxxxxxxxxxxxxxx') }}", // Remplacez par votre clé publique KKiaPay
            sandbox: {{ env('KKIAPAY_SANDBOX', 'true') }}, // true pour le mode test, false pour la production
        });

        // Gérer le clic sur le bouton
        document.getElementById('kkiapay-button').addEventListener('click', function() {
            openKkiapayWidget({
                amount: {{ $payment->amount }},
                position: "center",
                callback: "",
                data: "",
                theme: "#15803d",
                key: "{{ env('KKIAPAY_PUBLIC_KEY', 'pk_test_xxxxxxxxxxxxxxx') }}",
                sandbox: {{ env('KKIAPAY_SANDBOX', 'true') }},
            });
        });

        // Écouter les événements KKiaPay
        addKkiapayListener('success', function(response) {
            console.log('Paiement réussi:', response);
            
            // Envoyer les données au serveur
            fetch("{{ route('event.payment.kkiapay.callback') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    transaction_id: response.transactionId,
                    payment_id: {{ $payment->id }}
                })
            }).then(() => {
                // Rediriger vers la page de vérification
                window.location.href = "{{ route('event.payment.verify', ['eventSlug' => $eventSlug, 'paymentId' => $payment->id]) }}";
            });
        });

        addKkiapayListener('failed', function(response) {
            console.log('Paiement échoué:', response);
            alert('Le paiement a échoué. Veuillez réessayer.');
        });

        addKkiapayListener('pending', function(response) {
            console.log('Paiement en attente:', response);
            alert('Votre paiement est en cours de traitement.');
        });
    });
</script>
@endsection
