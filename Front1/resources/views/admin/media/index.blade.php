@extends('layouts.admin')

@section('title', 'Gestion des Médias')

@section('content')
<x-crud-table 
    :items="$medias" 
    :columns="[
        ['key' => 'id_media', 'label' => 'ID'],
        ['key' => 'nom_fichier', 'label' => 'Nom du fichier'],
        ['key' => 'type_fichier', 'label' => 'Type'],
        ['key' => 'nom_type_media', 'label' => 'Catégorie', 'relation' => 'typeMedia'],
        ['key' => 'taille', 'label' => 'Taille'],
    ]"
    resource="admin.media"
    createRoute="{{ route('admin.media.create') }}"
>
    Gestion des Médias
</x-crud-table>
@endsection