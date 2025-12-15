@extends('layouts.app')

@section('title','Paiement — Gastronomie')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-24 text-center">
  <div class="bg-white rounded-lg p-8 shadow">
    <h1 class="text-2xl font-semibold">Merci pour votre commande</h1>
    <p class="mt-4 text-gray-600">Référence de la commande : <strong>{{ $order->id }}</strong></p>
    <p class="mt-2 text-gray-600">Montant payé : <strong class="text-amber-600">{{ number_format($order->total,0,',',' ') }} FCFA</strong></p>
    <p class="mt-4 text-gray-700">Statut : <strong>{{ $order->paid ? 'Payé' : 'En attente' }}</strong></p>
    <div class="mt-6">
      <a href="{{ route('gastronomie') }}" class="px-4 py-2 rounded bg-amber-500 text-white">Retour à la gastronomie</a>
    </div>
  </div>
</div>
@endsection
