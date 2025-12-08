@extends('layouts.admin')

@section('title', 'Gestion des Commentaires')

@section('content')
<x-crud-table 
    :items="$commentaires" 
    :columns="[
        ['key' => 'id_commentaire', 'label' => 'ID'],
        ['key' => 'prenom', 'label' => 'Auteur', 'relation' => 'utilisateur'],
        ['key' => 'titre', 'label' => 'Contenu', 'relation' => 'contenu'],
        ['key' => 'contenu_commentaire', 'label' => 'Commentaire'],
        ['key' => 'est_approuve', 'label' => 'Statut', 'format' => 'badge'],
        ['key' => 'created_at', 'label' => 'Date', 'format' => 'date'],
    ]"
    resource="admin.commentaires"
    createRoute="{{ route('admin.commentaires.create') }}"
>
    Gestion des Commentaires
</x-crud-table>
@endsection