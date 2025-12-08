<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExplorerController extends Controller
{
    // Liste des items (mock) — on pourra remplacer par Eloquent plus tard
    private function sampleItems()
    {
        return [
            ['slug'=>'tapisserie-en-coton','titre'=>'Tapisserie en coton','type'=>'textile','region'=>'Parakou','prix'=>25000,'note'=>4.5,'artisan'=>'Adjani K.','image'=>'https://images.unsplash.com/photo-1520975915143-8d5c2f0a2f8b?auto=format&fit=crop&w=800&q=60'],
            ['slug'=>'statue-en-bois','titre'=>'Statue en bois','type'=>'sculpture','region'=>'Abomey','prix'=>50000,'note'=>4.8,'artisan'=>'Fatoumata S.','image'=>'https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?auto=format&fit=crop&w=800&q=60'],
            ['slug'=>'collier-de-perles','titre'=>'Collier de perles','type'=>'bijoux','region'=>'Ouidah','prix'=>15000,'note'=>4.2,'artisan'=>'Aminata B.','image'=>'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=800&q=60'],
        ];
    }

    public function index(Request $request)
    {
        $q = strtolower($request->query('q',''));
        $type = $request->query('type','all');

        $items = collect($this->sampleItems())->filter(function($it) use ($q, $type){
            $ok = true;
            if ($type !== 'all' && $it['type'] !== $type) $ok = false;
            if ($q && strpos(strtolower($it['titre'].' '.$it['artisan'].' '.$it['region']), $q) === false) $ok = false;
            return $ok;
        })->values()->all();

        return view('pages.explorer', compact('items','q','type'));
    }

    public function show($slug)
    {
        $item = collect($this->sampleItems())->firstWhere('slug', $slug);
        if (!$item) abort(404);
        return view('pages.explorer.show', ['item' => $item]);
    }
}
