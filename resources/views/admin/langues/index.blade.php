@extends('layouts.admin')

@section('title', 'Gestion des Langues')

@section('content')
<x-crud-table 
    :items="$langues" 
    :columns="[
        ['key' => 'id_langue', 'label' => 'ID'],
        ['key' => 'nom_langue', 'label' => 'Nom'],
        ['key' => 'code_langue', 'label' => 'Code'],
        ['key' => 'contenus_count', 'label' => 'Nb Contenus'],
    ]"
    resource="admin.langues"
    createRoute="{{ route('admin.langues.create') }}"
>
    Gestion des Langues
</x-crud-table>
@endsection