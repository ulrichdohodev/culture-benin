@extends('layouts.admin')

@section('title', 'Gestion des Contenus')

@section('content')
<x-crud-table 
    :items="$contenus" 
    :columns="[
        ['key' => 'id_contenu', 'label' => 'ID'],
        ['key' => 'titre', 'label' => 'Titre'],
        ['key' => 'nom_region', 'label' => 'Région', 'relation' => 'region'],
        ['key' => 'nom_langue', 'label' => 'Langue', 'relation' => 'langue'],
        ['key' => 'nom_contenu', 'label' => 'Type', 'relation' => 'typeContenu'],
        ['key' => 'statut', 'label' => 'Statut', 'format' => 'badge'],
        ['key' => 'created_at', 'label' => 'Créé le', 'format' => 'date'],
    ]"
    resource="admin.contenus"
    createRoute="{{ route('admin.contenus.create') }}"
>
    Gestion des Contenus
</x-crud-table>
@endsection