@extends('layouts.guest')

@section('content')
    <div>
        <h2 class="text-3xl font-bold mb-6">Explorer les contenus</h2>

        @if($contenus->isEmpty())
            <p class="text-gray-700">Aucun contenu n'a encore été publié.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($contenus as $contenu)
                    <article class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $contenu->titre }}</h3>
                        <p class="text-sm text-gray-500 mb-3">@if($contenu->region) Région : {{ $contenu->region->nom_region }} @endif @if($contenu->typeContenu) • Type : {{ $contenu->typeContenu->nom_type }} @endif</p>
                        <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($contenu->texte), 220) }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div>Par {{ optional($contenu->auteur)->prenom }} {{ optional($contenu->auteur)->nom }}</div>
                            <div>{{ optional($contenu->date_creation)->format('d/m/Y') ?? '' }}</div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.contenus.show', $contenu) }}" class="text-benin-yellow">Lire la suite</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $contenus->links() }}
            </div>
        @endif
    </div>
@endsection
