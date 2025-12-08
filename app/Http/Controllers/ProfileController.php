<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Utilisateur;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Afficher le formulaire d'édition du profil (route: profile.edit)
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', ['user' => $user]);
    }

    // Mettre à jour le profil (route: profile.update)
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'prenom' => 'nullable|string|max:100',
            'nom' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:40',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'pays' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048',
            'current_password' => 'nullable|string',
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Update basic fields
        $user->prenom = $data['prenom'] ?? $user->prenom;
        $user->nom = $data['nom'] ?? $user->nom;
        $user->email = $data['email'] ?? $user->email;
        $user->telephone = $data['telephone'] ?? $user->telephone;
        $user->adresse = $data['adresse'] ?? $user->adresse;
        $user->ville = $data['ville'] ?? $user->ville;
        $user->pays = $data['pays'] ?? $user->pays;

        // Photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profiles', 'public');
            // supprimer ancien fichier si présent
            if (!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $path;
        }

        // Changement de mot de passe si demandé
        if (!empty($data['password'])) {
            if (empty($data['current_password']) || !Hash::check($data['current_password'], $user->mot_de_passe)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }
            $user->mot_de_passe = $data['password']; // cast 'hashed' in model will hash it
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }

    // Supprimer le compte (route: profile.destroy)
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Optional: delete profile photo
        if (!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Compte supprimé avec succès.');
    }
}

