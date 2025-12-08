<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parler;
use App\Models\Region;
use App\Models\Langue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParlerController extends Controller
{
    // Access control handled via route middleware

    public function index()
    {
        $parlers = Parler::with(['region', 'langue'])
            ->orderBy('id_region')
            ->paginate(10);
            
        return view('admin.parler.index', compact('parlers'));
    }

    public function create()
    {
        $regions = Region::all();
        $langues = Langue::all();
        
        return view('admin.parler.create', compact('regions', 'langues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'pourcentage_locuteurs' => 'required|numeric|min:0|max:100',
            'est_principale' => 'boolean',
        ]);

        Parler::create($validated);

        return redirect()->route('admin.parler.index')
            ->with('success', 'Relation région-langue créée avec succès.');
    }

    public function show(Parler $parler)
    {
        return view('admin.parler.show', compact('parler'));
    }

    public function edit(Parler $parler)
    {
        $regions = Region::all();
        $langues = Langue::all();
        
        return view('admin.parler.edit', compact('parler', 'regions', 'langues'));
    }

    public function update(Request $request, Parler $parler)
    {
        $validated = $request->validate([
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'pourcentage_locuteurs' => 'required|numeric|min:0|max:100',
            'est_principale' => 'boolean',
        ]);

        $parler->update($validated);

        return redirect()->route('admin.parler.index')
            ->with('success', 'Relation région-langue modifiée avec succès.');
    }

    public function destroy(Parler $parler)
    {
        $parler->delete();

        return redirect()->route('admin.parler.index')
            ->with('success', 'Relation région-langue supprimée avec succès.');
    }

}