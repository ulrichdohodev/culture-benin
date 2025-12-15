@extends('layouts.guest')

@section('content')
<div>
    <h2 class="text-3xl font-bold mb-6">Langues</h2>

    @if($langues->isEmpty())
        <p class="text-gray-700">Aucune langue trouvée.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($langues as $langue)
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-semibold text-lg">{{ $langue->nom_langue }}</h3>
                    <p class="text-sm text-gray-500">Contenus : {{ $langue->contenus_count ?? 0 }}</p>
                    <div class="mt-3">
                        <a href="{{ route('admin.langues.show', $langue) }}" class="text-benin-yellow">Voir</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $langues->links() }}
        </div>
    @endif
</div>
@endsection
