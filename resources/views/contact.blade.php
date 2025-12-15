@extends('layouts.app')

@section('title','Contact')

@section('content')
    <x-page-header title="Contact" subtitle="Une équipe réactive pour vos questions, partenariats et contributions." />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
                <p class="font-semibold mb-2">Merci de corriger les champs suivants :</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Infos de contact -->
            <div class="bg-white rounded-2xl shadow-sm border p-6 space-y-6">
                <div>
                    <p class="text-sm uppercase tracking-wide text-green-700 font-semibold">Nous joindre</p>
                    <h2 class="text-2xl font-bold text-gray-900 mt-2">Coordonnées directes</h2>
                    <p class="text-gray-600 mt-2">Choisissez le canal qui vous convient le mieux, nous répondons sous 24h (ouvrés).</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center">📞</div>
                        <div>
                            <p class="text-sm text-gray-500">Téléphone / WhatsApp</p>
                            <p class="font-semibold text-gray-900">+229 12 34 56 78</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center">✉️</div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-semibold text-gray-900">contact@culture-benin.org</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center">📍</div>
                        <div>
                            <p class="text-sm text-gray-500">Adresse</p>
                            <p class="font-semibold text-gray-900">Cotonou, Bénin</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center">⏰</div>
                        <div>
                            <p class="text-sm text-gray-500">Horaires</p>
                            <p class="font-semibold text-gray-900">Lun - Ven : 9h - 18h</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-green-50 border border-green-100 rounded-xl">
                    <p class="text-sm text-gray-700">Pour les partenariats médias, institutions ou événements, précisez la date, le lieu et l’objectif : nous reviendrons vers vous avec une proposition adaptée.</p>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Écrivez-nous</h3>
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border rounded-md p-3 focus:ring-green-500 focus:border-green-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border rounded-md p-3 focus:ring-green-500 focus:border-green-500" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Objet</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Suggestion, collaboration, support..." class="mt-1 block w-full border rounded-md p-3 focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea name="message" rows="6" class="mt-1 block w-full border rounded-md p-3 focus:ring-green-500 focus:border-green-500" required>{{ old('message') }}</textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <p class="text-sm text-gray-500">Réponse sous 24h (ouvrés). Nous ne partageons jamais vos données.</p>
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 transition">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bloc FAQ court -->
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border rounded-xl p-5 shadow-sm">
                <p class="text-sm text-gray-500">Support technique</p>
                <p class="font-semibold text-gray-900 mt-2">Problème de connexion ou de publication ? Décrivez l’erreur et joignez une capture d’écran.</p>
            </div>
            <div class="bg-white border rounded-xl p-5 shadow-sm">
                <p class="text-sm text-gray-500">Partenariats / Presse</p>
                <p class="font-semibold text-gray-900 mt-2">Événements, médias, institutions : précisez vos dates, audiences et besoins de visibilité.</p>
            </div>
            <div class="bg-white border rounded-xl p-5 shadow-sm">
                <p class="text-sm text-gray-500">Contributions</p>
                <p class="font-semibold text-gray-900 mt-2">Vous voulez partager un contenu culturel ? Indiquez le thème, la région et les supports disponibles.</p>
            </div>
        </div>
    </div>

@endsection
