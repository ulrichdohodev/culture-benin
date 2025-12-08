<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\TypeMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    // Access control handled via route middleware

    public function index()
    {
        $medias = Media::with('typeMedia')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.media.index', compact('medias'));
    }

    public function create()
    {
        $typeMedia = TypeMedia::all();
        return view('admin.media.create', compact('typeMedia'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_fichier' => 'nullable|string|max:255',
            'chemin_fichier' => 'required|file',
            'id_type_media' => 'required|exists:type_media,id_type_media',
            'id_contenu' => 'nullable|exists:contenus,id_contenu',
            'description' => 'nullable|string',
        ]);

        $data = [
            'description' => $validated['description'] ?? null,
            'id_type_media' => $validated['id_type_media'],
            'id_contenu' => $validated['id_contenu'] ?? null,
        ];

        if ($request->hasFile('chemin_fichier')) {
            $file = $request->file('chemin_fichier');
            $path = $file->store('medias', 'public');
            // map to DB column `chemin`
            $data['chemin'] = $path;
            // optional metadata (not stored in media table by default)
            $data['type_fichier'] = $file->getClientMimeType();
            $data['taille'] = $file->getSize();
        }

        Media::create($data);

        return redirect()->route('admin.media.index')
            ->with('success', 'Média créé avec succès.');
    }

    public function show(Media $media)
    {
        return view('admin.media.show', compact('media'));
    }

    public function edit(Media $media)
    {
        $typeMedia = TypeMedia::all();
        return view('admin.media.edit', compact('media', 'typeMedia'));
    }

    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'nom_fichier' => 'nullable|string|max:255',
            'id_type_media' => 'required|exists:type_media,id_type_media',
            'description' => 'nullable|string',
        ]);

        $data = [
            'description' => $validated['description'] ?? $media->description,
            'id_type_media' => $validated['id_type_media'] ?? $media->id_type_media,
        ];

        if ($request->hasFile('chemin_fichier')) {
            // Supprimer l'ancien fichier
            if ($media->chemin) {
                Storage::disk('public')->delete($media->chemin);
            }

            $file = $request->file('chemin_fichier');
            $path = $file->store('medias', 'public');
            $data['chemin'] = $path;
            $data['type_fichier'] = $file->getClientMimeType();
            $data['taille'] = $file->getSize();
        }

        $media->update($data);

        return redirect()->route('admin.media.index')
            ->with('success', 'Média modifié avec succès.');
    }

    public function destroy(Media $media)
    {
        if ($media->chemin) {
            Storage::disk('public')->delete($media->chemin);
        }

        $media->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Média supprimé avec succès.');
    }

}