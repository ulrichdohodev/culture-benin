@extends('layouts.admin')

@section('title', 'Gestion des Types de Média')

@section('content')
<x-crud-table 
    :items="$typeMedia" 
    :columns="[
        ['key' => 'id_type_media', 'label' => 'ID'],
        ['key' => 'nom_type_media', 'label' => 'Nom'],
        ['key' => 'description', 'label' => 'Description'],
        ['key' => 'media_count', 'label' => 'Nb Médias'],
    ]"
    resource="admin.type-media"
    createRoute="{{ route('admin.type-media.create') }}"
>
    Gestion des Types de Média
</x-crud-table>
@endsection