<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeMediaController extends Controller
{

    public function index()
    {
        $typeMedia = TypeMedia::withCount('medias')
            ->orderBy('nom_type_media')
            ->paginate(10);
            
        return view('admin.type-media.index', compact('typeMedia'));
    }

    public function create()
    {
        return view('admin.type-media.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_type_media' => 'required|string|max:255|unique:type_media',
            'description' => 'nullable|string',
        ]);

        TypeMedia::create($validated);

        return redirect()->route('admin.type-media.index')
            ->with('success', 'Type de média créé avec succès.');
    }

    public function show(TypeMedia $typeMedia)
    {
        return view('admin.type-media.show', compact('typeMedia'));
    }

    public function edit(TypeMedia $typeMedia)
    {
        return view('admin.type-media.edit', compact('typeMedia'));
    }

    public function update(Request $request, TypeMedia $typeMedia)
    {
        $validated = $request->validate([
            'nom_type_media' => 'required|string|max:255|unique:type_media,nom_type_media,' . $typeMedia->id_type_media . ',id_type_media',
            'description' => 'nullable|string',
        ]);

        $typeMedia->update($validated);

        return redirect()->route('admin.type-media.index')
            ->with('success', 'Type de média modifié avec succès.');
    }

    public function destroy(TypeMedia $typeMedia)
    {
        $typeMedia->delete();

        return redirect()->route('admin.type-media.index')
            ->with('success', 'Type de média supprimé avec succès.');
    }

}