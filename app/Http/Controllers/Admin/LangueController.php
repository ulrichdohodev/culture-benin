<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Langue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LangueController extends Controller
{
    // Access control handled via route middleware

    public function index()
    {
        $langues = Langue::withCount('contenus')
            ->orderBy('nom_langue')
            ->paginate(10);
            
        return view('admin.langues.index', compact('langues'));
    }

    public function create()
    {
        return view('admin.langues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_langue' => 'required|string|max:255|unique:langues',
            'code_langue' => 'required|string|max:10|unique:langues',
            'description' => 'nullable|string',
        ]);

        Langue::create($validated);

        return redirect()->route('admin.langues.index')
            ->with('success', 'Langue créée avec succès.');
    }

    public function show(Langue $langue)
    {
        return view('admin.langues.show', compact('langue'));
    }

    public function edit(Langue $langue)
    {
        return view('admin.langues.edit', compact('langue'));
    }

    public function update(Request $request, Langue $langue)
    {
        $validated = $request->validate([
            'nom_langue' => 'required|string|max:255|unique:langues,nom_langue,' . $langue->id_langue . ',id_langue',
            'code_langue' => 'required|string|max:10|unique:langues,code_langue,' . $langue->id_langue . ',id_langue',
            'description' => 'nullable|string',
        ]);

        $langue->update($validated);

        return redirect()->route('admin.langues.index')
            ->with('success', 'Langue modifiée avec succès.');
    }

    public function destroy(Langue $langue)
    {
        $langue->delete();

        return redirect()->route('admin.langues.index')
            ->with('success', 'Langue supprimée avec succès.');
    }

}