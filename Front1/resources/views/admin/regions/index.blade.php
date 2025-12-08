@extends('layouts.admin')

@section('title', 'Gestion des Régions')

@section('content')
<x-crud-table 
    :items="$regions" 
    :columns="[
        ['key' => 'id_region', 'label' => 'ID'],
        ['key' => 'nom_region', 'label' => 'Nom'],
        ['key' => 'description', 'label' => 'Description'],
        ['key' => 'contenus_count', 'label' => 'Nb Contenus'],
    ]"
    resource="admin.regions"
    createRoute="{{ route('admin.regions.create') }}"
>
    Gestion des Régions
</x-crud-table>
@endsection