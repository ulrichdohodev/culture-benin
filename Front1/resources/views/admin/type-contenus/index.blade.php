@extends('layouts.admin')

@section('title', 'Gestion des Types de Contenu')

@section('content')
<x-crud-table 
    :items="$typeContenus" 
    :columns="[
        ['key' => 'id_type_contenu', 'label' => 'ID'],
        ['key' => 'nom_contenu', 'label' => 'Nom'],
        ['key' => 'description', 'label' => 'Description'],
        ['key' => 'contenus_count', 'label' => 'Nb Contenus'],
    ]"
    resource="admin.type-contenus"
    createRoute="{{ route('admin.type-contenus.create') }}"
>
    Gestion des Types de Contenu
</x-crud-table>
@endsection