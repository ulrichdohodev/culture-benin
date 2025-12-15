@extends('layouts.app')

@section('title','Explorer')

@section('content')
<x-page-header title="Explorer" subtitle="Recherchez des œuvres, artisans et contenus." />

@php
    $items = $items ?? [];
    $q = $q ?? '';
    $type = $type ?? 'all';
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <form method="GET" action="{{ route('explorer') }}" class="mb-6 flex gap-3 items-center">
        <input id="searchInput" name="q" value="{{ $q }}" type="text" placeholder="Rechercher..." class="flex-1 border rounded px-3 py-2">
        <select id="typeFilter" name="type" class="border rounded px-2 py-2">
            <option value="all" {{ $type==='all'?'selected':'' }}>Tous</option>
            <option value="textile" {{ $type==='textile'?'selected':'' }}>Textile</option>
            <option value="sculpture" {{ $type==='sculpture'?'selected':'' }}>Sculpture</option>
            <option value="bijoux" {{ $type==='bijoux'?'selected':'' }}>Bijoux</option>
        </select>
        <button class="px-4 py-2 bg-green-600 text-white rounded">Rechercher</button>
    </form>

    <div id="itemsGrid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($items as $it)
        <div class="bg-white rounded-lg shadow p-4 explorer-item" data-type="{{ $it['type'] }}">
            <img src="{{ $it['image'] }}" class="w-full h-40 object-cover rounded">
            <h3 class="mt-3 font-semibold">{{ $it['titre'] }}</h3>
            <p class="text-sm text-gray-600">{{ $it['artisan'] }} — {{ $it['region'] }}</p>
            <div class="mt-2 flex items-center justify-between">
                <div class="text-lg font-bold">{{ number_format($it['prix'],0,',',' ') }} FCFA</div>
                <div class="text-sm text-gray-600">⭐ {{ $it['note'] }}</div>
            </div>
            <div class="mt-3">
                <a href="{{ route('explorer.show', $it['slug']) }}" class="text-benin-yellow">Voir</a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('input', applyFilters);
document.getElementById('typeFilter').addEventListener('change', applyFilters);
function applyFilters(){
    const q = document.getElementById('searchInput').value.toLowerCase();
    const type = document.getElementById('typeFilter').value;
    document.querySelectorAll('.explorer-item').forEach(el=>{
        const text = el.textContent.toLowerCase();
        const itType = el.dataset.type;
        let ok = true;
        if(type!=='all' && itType!==type) ok=false;
        if(q && !text.includes(q)) ok=false;
        el.style.display = ok ? '' : 'none';
    });
}
</script>
@endpush

@endsection
