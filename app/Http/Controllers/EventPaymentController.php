<?php

namespace App\Http\Controllers;

use App\Models\EventPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventPaymentController extends Controller
{
    /**
     * Afficher le formulaire de paiement pour un événement
     */
    public function show($eventSlug)
    {
        $events = [
            'festival-des-rythmes' => [
                'title' => 'Festival des Rythmes',
                'date' => '15 DÉC',
                'lieu' => 'Cotonou',
                'price' => 5000,
                'description' => 'Un événement culturel incontournable avec des performances traditionnelles et modernes.',
                'details' => 'Le Festival des Rythmes célèbre la richesse musicale du Bénin à travers des concerts, des ateliers et des rencontres avec des artistes de renom.',
                'img' => 'images/events/festival-rythmes.jpg',
            ],
            'fete-des-arts' => [
                'title' => 'Fête des Arts',
                'date' => '20 JAN',
                'lieu' => 'Abomey',
                'price' => 3000,
                'description' => 'Une célébration de l\'artisanat et des arts visuels béninois.',
                'details' => 'La Fête des Arts rassemble les meilleurs artisans du Bénin pour exposer leurs œuvres et partager leur savoir-faire avec le public.',
                'img' => 'images/events/fete-des-arts.jpg',
            ],
            'nuit-du-conte' => [
                'title' => 'Nuit du Conte',
                'date' => '05 FÉV',
                'lieu' => 'Porto-Novo',
                'price' => 2000,
                'description' => 'Une soirée magique dédiée aux contes et légendes béninoises.',
                'details' => 'La Nuit du Conte transporte le public dans l\'univers fascinant des légendes béninoises racontées par les meilleurs conteurs du pays.',
                'img' => 'images/events/nuit-du-conte.jpg',
            ],
        ];

        if (!isset($events[$eventSlug])) {
            abort(404);
        }

        $event = $events[$eventSlug];
        $event['slug'] = $eventSlug;

        // Vérifier si l'utilisateur a déjà payé pour cet événement
        $hasPaid = false;
        if (Auth::check()) {
            $hasPaid = EventPayment::where('user_email', Auth::user()->email)
                ->where('event_name', $event['title'])
                ->where('payment_status', 'completed')
                ->exists();
        }

        return view('pages.evenements.payment', compact('event', 'hasPaid'));
    }

    /**
     * Traiter le paiement
     */
    public function process(Request $request, $eventSlug)
    {
        $events = [
            'festival-des-rythmes' => ['title' => 'Festival des Rythmes', 'price' => 5000],
            'fete-des-arts' => ['title' => 'Fête des Arts', 'price' => 3000],
            'nuit-du-conte' => ['title' => 'Nuit du Conte', 'price' => 2000],
        ];

        if (!isset($events[$eventSlug])) {
            return back()->with('error', 'Événement introuvable.');
        }

        $event = $events[$eventSlug];

        $validated = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'payment_method' => 'required|in:kkiapay',
        ]);

        // Créer l'enregistrement de paiement
        $payment = EventPayment::create([
            'event_name' => $event['title'],
            'user_email' => $validated['email'],
            'user_id' => Auth::id(),
            'amount' => $event['price'],
            'payment_method' => $validated['payment_method'],
            'payment_reference' => 'EVT-' . strtoupper(Str::random(10)),
            'payment_status' => 'pending',
            'phone_number' => $validated['phone'],
        ]);

        // Si KKiaPay est sélectionné, rediriger vers la page de paiement KKiaPay
        if ($validated['payment_method'] === 'kkiapay') {
            return view('pages.evenements.kkiapay', [
                'payment' => $payment,
                'eventSlug' => $eventSlug,
                'event' => $event,
            ]);
        }

        // Simuler l'intégration du paiement mobile money
        // En production, vous intégreriez ici l'API du fournisseur de paiement
        // (MTN Mobile Money, Moov Money, etc.)

        return redirect()->route('event.payment.verify', [
            'eventSlug' => $eventSlug,
            'paymentId' => $payment->id
        ]);
    }

    /**
     * Vérifier et confirmer le paiement
     */
    public function verify($eventSlug, $paymentId)
    {
        $payment = EventPayment::findOrFail($paymentId);

        // En production, vérifier le statut du paiement via l'API du fournisseur
        // Pour la démo, on simule un paiement réussi
        if ($payment->payment_status === 'pending') {
            $payment->update([
                'payment_status' => 'completed',
                'paid_at' => now(),
            ]);
        }

        return view('pages.evenements.verify', compact('payment', 'eventSlug'));
    }

    /**
     * Callback KKiaPay - appelé après un paiement réussi
     */
    public function kkiapayCallback(Request $request)
    {
        // Récupérer les données de KKiaPay
        $transactionId = $request->input('transaction_id');
        $paymentId = $request->input('payment_id');

        if ($paymentId) {
            $payment = EventPayment::find($paymentId);
            
            if ($payment && $payment->payment_status === 'pending') {
                $payment->update([
                    'payment_status' => 'completed',
                    'paid_at' => now(),
                    'payment_reference' => $transactionId ?? $payment->payment_reference,
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Afficher les détails de l'événement après paiement
     */
    public function details($eventSlug)
    {
        $events = [
            'festival-des-rythmes' => [
                'title' => 'Festival des Rythmes',
                'date' => '15 DÉC',
                'lieu' => 'Cotonou',
                'price' => 5000,
                'description' => 'Un événement culturel incontournable avec des performances traditionnelles et modernes.',
                'details' => 'Le Festival des Rythmes célèbre la richesse musicale du Bénin à travers des concerts, des ateliers et des rencontres avec des artistes de renom. Au programme : concerts de musique traditionnelle, démonstrations de danse, ateliers de percussion, conférences sur l\'histoire musicale du Bénin, et bien plus encore.',
                'img' => 'images/events/festival-rythmes.jpg',
                'programme' => [
                    '14h00 - Ouverture et cérémonie traditionnelle',
                    '15h00 - Concert de l\'orchestre national',
                    '17h00 - Ateliers de percussion pour tous',
                    '19h00 - Spectacle de danse contemporaine',
                    '21h00 - Grand concert de clôture',
                ],
            ],
            'fete-des-arts' => [
                'title' => 'Fête des Arts',
                'date' => '20 JAN',
                'lieu' => 'Abomey',
                'price' => 3000,
                'description' => 'Une célébration de l\'artisanat et des arts visuels béninois.',
                'details' => 'La Fête des Arts rassemble les meilleurs artisans du Bénin pour exposer leurs œuvres et partager leur savoir-faire avec le public. Sculptures, peintures, tissages et bien d\'autres créations seront à découvrir.',
                'img' => 'images/events/fete-des-arts.jpg',
                'programme' => [
                    '10h00 - Ouverture de l\'exposition',
                    '11h00 - Démonstrations de sculpture sur bois',
                    '14h00 - Ateliers de peinture traditionnelle',
                    '16h00 - Défilé de mode avec pagnes traditionnels',
                    '18h00 - Vente aux enchères d\'œuvres d\'art',
                ],
            ],
            'nuit-du-conte' => [
                'title' => 'Nuit du Conte',
                'date' => '05 FÉV',
                'lieu' => 'Porto-Novo',
                'price' => 2000,
                'description' => 'Une soirée magique dédiée aux contes et légendes béninoises.',
                'details' => 'La Nuit du Conte transporte le public dans l\'univers fascinant des légendes béninoises racontées par les meilleurs conteurs du pays. Une expérience immersive pour toute la famille.',
                'img' => 'images/events/nuit-du-conte.jpg',
                'programme' => [
                    '19h00 - Accueil autour d\'un feu de camp',
                    '19h30 - Contes pour enfants',
                    '20h30 - Légendes des rois d\'Abomey',
                    '21h30 - Contes mystiques du vaudou',
                    '22h30 - Clôture et dégustation',
                ],
            ],
        ];

        if (!isset($events[$eventSlug])) {
            abort(404);
        }

        $event = $events[$eventSlug];
        $event['slug'] = $eventSlug;

        // Vérifier que l'utilisateur a payé
        $hasPaid = false;
        if (Auth::check()) {
            $hasPaid = EventPayment::where('user_email', Auth::user()->email)
                ->where('event_name', $event['title'])
                ->where('payment_status', 'completed')
                ->exists();
        }

        if (!$hasPaid) {
            return redirect()->route('event.payment.show', $eventSlug)
                ->with('error', 'Vous devez d\'abord effectuer le paiement pour accéder aux détails de cet événement.');
        }

        return view('pages.evenements.details', compact('event'));
    }
}
