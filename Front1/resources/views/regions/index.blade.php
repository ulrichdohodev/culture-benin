@extends('layouts.guest')

@section('content')
<div>
    <h2 class="text-3xl font-bold mb-6">Régions</h2>

    @if($regions->isEmpty())
        <p class="text-gray-700">Aucune région trouvée.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($regions as $region)
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-semibold text-lg">{{ $region->nom_region }}</h3>
                    <p class="text-sm text-gray-500">Contenus : {{ $region->contenus_count ?? 0 }}</p>
                    <div class="mt-3">
                        <a href="{{ route('admin.regions.show', $region) }}" class="text-benin-yellow">Voir</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $regions->links() }}
        </div>
    @endif
</div>
@endsection
