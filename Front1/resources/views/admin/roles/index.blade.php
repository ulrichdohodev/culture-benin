@extends('layouts.admin')

@section('title', 'Gestion des Rôles')

@section('content')
<x-crud-table 
    :items="$roles" 
    :columns="[
        ['key' => 'id_role', 'label' => 'ID'],
        ['key' => 'nom_role', 'label' => 'Nom du rôle'],
        ['key' => 'utilisateurs_count', 'label' => 'Nb Utilisateurs'],
    ]"
    resource="admin.roles"
    createRoute="{{ route('admin.roles.create') }}"
>
    Gestion des Rôles
</x-crud-table>
@endsection