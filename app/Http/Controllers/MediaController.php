<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $medias = Media::with('typeMedia')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.media.index', compact('medias'));
    }

    public function create()
    {
        return redirect()->route('admin.media.create');
    }

    public function store(Request $request)
    {
        // Public uploading is redirected to the admin media create flow.
        return redirect()->route('admin.media.create')->with('info', 'Upload des médias géré via la page de gestion des médias.');
    }

    public function show(Media $media)
    {
        return redirect()->route('admin.media.show', $media->id_media ?? $media->id);
    }

    /**
     * Allow the uploader (owner) to delete their media (also deletes file on disk).
     */
    public function destroy(Media $media)
    {
        // Deletion and management of medias is managed via admin interface.
        return redirect()->route('admin.media.index')->with('info', 'Gestion et suppression des médias disponible dans l’administration.');
    }
}
