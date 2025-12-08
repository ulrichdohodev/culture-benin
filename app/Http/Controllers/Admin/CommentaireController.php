<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commentaire;
use App\Models\Contenu;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    // Access control handled via route middleware

    public function index()
    {
        $commentaires = Commentaire::with(['utilisateur', 'contenu'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.commentaires.index', compact('commentaires'));
    }

    public function create()
    {
        $contenus = Contenu::all();
        $utilisateurs = Utilisateur::where('statut', 'actif')->get();
        
        return view('admin.commentaires.create', compact('contenus', 'utilisateurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'texte' => 'required|string',
            'note' => 'nullable|integer|min:1|max:5',
            'id_contenu' => 'required|exists:contenus,id_contenu',
            'id_utilisateur' => 'required|exists:utilisateurs,id_utilisateur',
        ]);

        Commentaire::create($validated);

        return redirect()->route('admin.commentaires.index')
            ->with('success', 'Commentaire créé avec succès.');
    }

    public function show(Commentaire $commentaire)
    {
        return view('admin.commentaires.show', compact('commentaire'));
    }

    public function edit(Commentaire $commentaire)
    {
        $contenus = Contenu::all();
        $utilisateurs = Utilisateur::where('statut', 'actif')->get();
        
        return view('admin.commentaires.edit', compact('commentaire', 'contenus', 'utilisateurs'));
    }

    public function update(Request $request, Commentaire $commentaire)
    {
        $validated = $request->validate([
            'texte' => 'required|string',
            'note' => 'nullable|integer|min:1|max:5',
            'id_contenu' => 'required|exists:contenus,id_contenu',
            'id_utilisateur' => 'required|exists:utilisateurs,id_utilisateur',
        ]);

        $commentaire->update($validated);

        return redirect()->route('admin.commentaires.index')
            ->with('success', 'Commentaire modifié avec succès.');
    }

    public function destroy(Commentaire $commentaire)
    {
        $commentaire->delete();

        return redirect()->route('admin.commentaires.index')
            ->with('success', 'Commentaire supprimé avec succès.');
    }
}