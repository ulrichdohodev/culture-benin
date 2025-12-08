@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<x-crud-table 
    :items="$utilisateurs" 
    :columns="[
        ['key' => 'id_utilisateur', 'label' => 'ID'],
        ['key' => 'prenom', 'label' => 'Prénom'],
        ['key' => 'nom', 'label' => 'Nom'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'nom_role', 'label' => 'Rôle', 'relation' => 'role'],
        ['key' => 'statut', 'label' => 'Statut', 'format' => 'badge'],
        ['key' => 'created_at', 'label' => 'Inscrit le', 'format' => 'date'],
    ]"
    resource="admin.utilisateurs"
    createRoute="{{ route('admin.utilisateurs.create') }}"
>
    Gestion des Utilisateurs
</x-crud-table>
@endsection