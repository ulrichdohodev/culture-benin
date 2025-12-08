@extends('layouts.admin')

@section('title', 'Relations Régions-Langues')

@section('content')
<x-crud-table 
    :items="$parlers" 
    :columns="[
        ['key' => 'id_parler', 'label' => 'ID'],
        ['key' => 'nom_region', 'label' => 'Région', 'relation' => 'region'],
        ['key' => 'nom_langue', 'label' => 'Langue', 'relation' => 'langue'],
        ['key' => 'pourcentage_locuteurs', 'label' => '% Locuteurs'],
        ['key' => 'est_principale', 'label' => 'Principale', 'format' => 'badge'],
    ]"
    resource="admin.parler"
    createRoute="{{ route('admin.parler.create') }}"
>
    Relations Régions-Langues
</x-crud-table>
@endsection