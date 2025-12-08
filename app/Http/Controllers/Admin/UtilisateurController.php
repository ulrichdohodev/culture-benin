<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Role;
use App\Models\Langue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UtilisateurController extends Controller
{

    public function index()
    {
        $utilisateurs = Utilisateur::with(['role', 'langue'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    public function create()
    {
        $roles = Role::all();
        $langues = Langue::all();
        
        return view('admin.utilisateurs.create', compact('roles', 'langues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs',
            'mot_de_passe' => 'required|min:8',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'required|date',
            'id_role' => 'required|exists:roles,id_role',
            'id_langue' => 'required|exists:langues,id_langue',
        ]);

        $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);
        
        Utilisateur::create($validated);

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(Utilisateur $utilisateur)
    {
        return view('admin.utilisateurs.show', compact('utilisateur'));
    }

    public function edit(Utilisateur $utilisateur)
    {
        $roles = Role::all();
        $langues = Langue::all();
        
        return view('admin.utilisateurs.edit', compact('utilisateur', 'roles', 'langues'));
    }

    public function update(Request $request, Utilisateur $utilisateur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email,' . $utilisateur->id_utilisateur . ',id_utilisateur',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'required|date',
            'id_role' => 'required|exists:roles,id_role',
            'id_langue' => 'required|exists:langues,id_langue',
            'statut' => 'required|in:actif,inactif',
        ]);

        if ($request->filled('mot_de_passe')) {
            $validated['mot_de_passe'] = bcrypt($request->mot_de_passe);
        }

        $utilisateur->update($validated);

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
