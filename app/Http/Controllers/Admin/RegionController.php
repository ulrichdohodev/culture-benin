<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{

    public function index()
    {
        $regions = Region::withCount('contenus')
            ->orderBy('nom_region')
            ->paginate(10);
            
        return view('admin.regions.index', compact('regions'));
    }

    public function create()
    {
        return view('admin.regions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_region' => 'required|string|max:255|unique:regions',
            'description' => 'nullable|string',
        ]);

        Region::create($validated);

        return redirect()->route('admin.regions.index')
            ->with('success', 'Région créée avec succès.');
    }

    public function show(Region $region)
    {
        return view('admin.regions.show', compact('region'));
    }

    public function edit(Region $region)
    {
        return view('admin.regions.edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        $validated = $request->validate([
            'nom_region' => 'required|string|max:255|unique:regions,nom_region,' . $region->id_region . ',id_region',
            'description' => 'nullable|string',
        ]);

        $region->update($validated);

        return redirect()->route('admin.regions.index')
            ->with('success', 'Région modifiée avec succès.');
    }

    public function destroy(Region $region)
    {
        $region->delete();

        return redirect()->route('admin.regions.index')
            ->with('success', 'Région supprimée avec succès.');
    }

}