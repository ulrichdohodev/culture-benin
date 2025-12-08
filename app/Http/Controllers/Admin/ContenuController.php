<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenu;
use App\Models\Region;
use App\Models\Langue;
use App\Models\TypeContenu;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use App\Models\Media as MediaModel;

class ContenuController extends Controller
{
    /**
     * Vérifier l'autorisation pour les méthodes admin
     */
    private function checkAdminAuth()
    {
        // Contrôle d'accès géré par les middlewares de routes ('auth' + 'role').
        // Cette méthode est conservée pour compatibilité mais ne fait plus de vérification.
        return;
    }

    /**
     * Afficher la liste des contenus
     */
    public function index()
    {
        $this->checkAdminAuth();

        $contenus = Contenu::with(['region', 'langue', 'typeContenu', 'auteur'])
            ->orderBy('date_creation', 'desc')
            ->paginate(10);

        return view('admin.contenus.index', compact('contenus'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $this->checkAdminAuth();

        $regions = Region::all();
        $langues = Langue::all();
        $typeContenus = TypeContenu::all();

        return view('admin.contenus.create', compact('regions', 'langues', 'typeContenus'));
    }

    /**
     * Stocker un nouveau contenu
     */
    public function store(Request $request)
    {
        $this->checkAdminAuth();

        $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
        ]);

        Contenu::create([
            'titre' => $request->titre,
            'texte' => $request->texte,
            'statut' => 'en_attente',
            'id_region' => $request->id_region,
            'id_langue' => $request->id_langue,
            'id_type_contenu' => $request->id_type_contenu,
            'id_auteur' => Auth::id(),
            'date_creation' => now(),
        ]);

        return redirect()->route('admin.contenus.index')
            ->with('success', 'Contenu créé avec succès.');
    }

    /**
     * Afficher un contenu spécifique
     */
    public function show(Contenu $contenu)
    {
        $this->checkAdminAuth();

        return view('admin.contenus.show', compact('contenu'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Contenu $contenu)
    {
        $this->checkAdminAuth();

        $regions = Region::all();
        $langues = Langue::all();
        $typeContenus = TypeContenu::all();

        return view('admin.contenus.edit', compact('contenu', 'regions', 'langues', 'typeContenus'));
    }

    /**
     * Mettre à jour un contenu
     */
    public function update(Request $request, Contenu $contenu)
    {
        $this->checkAdminAuth();

        $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
        ]);

        $contenu->update([
            'titre' => $request->titre,
            'texte' => $request->texte,
            'id_region' => $request->id_region,
            'id_langue' => $request->id_langue,
            'id_type_contenu' => $request->id_type_contenu,
        ]);

        return redirect()->route('admin.contenus.index')
            ->with('success', 'Contenu mis à jour avec succès.');
    }

    /**
     * Supprimer un contenu
     */
    public function destroy(Contenu $contenu)
    {
        $this->checkAdminAuth();

        $contenu->delete();

        return redirect()->route('admin.contenus.index')
            ->with('success', 'Contenu supprimé avec succès.');
    }

    /**
     * Allow the author to delete their own content (or admin)
     */
    public function destroyOwner(\Illuminate\Http\Request $request, Contenu $contenu)
    {
        if (!auth()->check()) {
            abort(403, 'Non authentifié.');
        }

        $user = auth()->user();
        $isAdmin = method_exists($user, 'isAdmin') && $user->isAdmin();

        // Only the author or an admin can delete here
        if (!$isAdmin && $contenu->id_auteur != $user->id) {
            abort(403, 'Action non autorisée.');
        }

        // If medias linkage exists, delete associated files and records
        try {
            if (Schema::hasTable('medias') && Schema::hasColumn('medias', 'id_contenu')) {
                $medias = MediaModel::where('id_contenu', $contenu->id_contenu)->get();
                foreach ($medias as $m) {
                    $path = $m->fichier ?? $m->chemin ?? null;
                    if ($path) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
                    }
                    $m->delete();
                }
            }
        } catch (\Exception $e) {
            // swallow errors here but continue deletion of content
        }

        $contenu->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Contenu supprimé.', 'id' => $contenu->id_contenu]);
        }

        return redirect()->route('mes-contenus')->with('success', 'Contenu supprimé.');
    }

    /**
     * Valider un contenu
     */
    public function valider(Contenu $contenu)
    {
        $this->checkAdminAuth();

        $contenu->update([
            'statut' => 'valide',
            'date_validation' => now(),
            'id_moderateur' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Contenu validé avec succès.');
    }

    /**
     * Rejeter un contenu
     */
    public function rejeter(\Illuminate\Http\Request $request, Contenu $contenu)
    {
        $this->checkAdminAuth();

        $validated = $request->validate([
            'motif_rejet' => 'nullable|string|max:2000',
        ]);

        $contenu->update([
            'statut' => 'rejete',
            'date_validation' => now(),
            'id_moderateur' => Auth::id(),
            'motif_rejet' => $validated['motif_rejet'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Contenu rejeté.');
    }

    /**
     * Méthode pour la création publique de contenu
     */
    public function storePublic(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Non authentifié.');
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
            'video' => 'nullable|file|mimes:mp4,mov,webm,avi|max:51200', // max 50MB
        ]);

        $contenu = Contenu::create([
            'titre' => $request->titre,
            'texte' => $request->texte,
            'statut' => 'en_attente',
            'id_region' => $request->id_region,
            'id_langue' => $request->id_langue,
            'id_type_contenu' => $request->id_type_contenu,
            'id_auteur' => Auth::id(),
            'date_creation' => now(),
        ]);

        // Si une vidéo est fournie, l'enregistrer et créer un Media associé
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $path = $file->store('videos', 'public');

            $mediaData = [
                'titre' => $file->getClientOriginalName(),
                'fichier' => $path,
                'mime' => $file->getClientMimeType(),
                'uploader_id' => Auth::id(),
                'description' => 'Vidéo liée au contenu ' . $contenu->id_contenu,
            ];

            // N'ajouter la clé id_contenu que si la colonne existe réellement
            if (Schema::hasColumn('medias', 'id_contenu')) {
                $mediaData['id_contenu'] = $contenu->id_contenu;
            }

            Media::create($mediaData);
        }

        return redirect()->route('mes-contenus')
            ->with('success', 'Contenu soumis avec succès. Il sera examiné par un modérateur.');
    }
}