<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeContenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeContenuController extends Controller
{
    // Access control handled via route middleware

    public function index()
    {
        $typeContenus = TypeContenu::withCount('contenus')
            ->orderBy('nom_contenu')
            ->paginate(10);
            
        return view('admin.type-contenus.index', compact('typeContenus'));
    }

    public function create()
    {
        return view('admin.type-contenus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_contenu' => 'required|string|max:255|unique:type_contenus',
            'description' => 'nullable|string',
        ]);

        TypeContenu::create($validated);

        return redirect()->route('admin.type-contenus.index')
            ->with('success', 'Type de contenu créé avec succès.');
    }

    public function show(TypeContenu $typeContenu)
    {
        return view('admin.type-contenus.show', compact('typeContenu'));
    }

    public function edit(TypeContenu $typeContenu)
    {
        return view('admin.type-contenus.edit', compact('typeContenu'));
    }

    public function update(Request $request, TypeContenu $typeContenu)
    {
        $validated = $request->validate([
            'nom_contenu' => 'required|string|max:255|unique:type_contenus,nom_contenu,' . $typeContenu->id_type_contenu . ',id_type_contenu',
            'description' => 'nullable|string',
        ]);

        $typeContenu->update($validated);

        return redirect()->route('admin.type-contenus.index')
            ->with('success', 'Type de contenu modifié avec succès.');
    }

    public function destroy(TypeContenu $typeContenu)
    {
        $typeContenu->delete();

        return redirect()->route('admin.type-contenus.index')
            ->with('success', 'Type de contenu supprimé avec succès.');
    }

}