<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\Admin\ContenuController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\LangueController;
use App\Http\Controllers\Admin\TypeContenuController;
use App\Http\Controllers\Admin\TypeMediaController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\CommentaireController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ParlerController;
use App\Http\Controllers\EventPaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\Contenu;
use App\Models\Region;
use App\Models\Langue;
use App\Models\Utilisateur;

// Health check endpoint for Render
Route::get('/healthz', function () {
    return response('OK', 200);
});

Route::get('/', function () {
    try {
        // Contenus approuvés récents
        $recents = Contenu::approuves()
            ->with(['region', 'typeContenu', 'auteur'])
            ->orderBy('date_creation', 'desc')
            ->take(6)
            ->get();

        // Actualités : contenus dont le type contient 'actualité' (si existant)
        $actualites = Contenu::approuves()
            ->whereHas('typeContenu', function ($q) {
                $q->where('nom_contenu', 'like', '%actualité%');
            })
            ->orderBy('date_creation', 'desc')
            ->take(5)
            ->get();

        // Populaires : par nombre de commentaires (fallback si commentaires absents)
        $populaires = Contenu::approuves()
            ->withCount('commentaires')
            ->orderBy('commentaires_count', 'desc')
            ->take(6)
            ->get();

        // Totaux pour la section call-to-action
        $totalContenus = Contenu::approuves()->count();
        $totalRegions = Region::count();
        $totalLangues = Langue::count();
        $totalUtilisateurs = Utilisateur::count();

        return view('welcome', compact('actualites', 'recents', 'populaires', 'totalContenus', 'totalRegions', 'totalLangues', 'totalUtilisateurs'));
    } catch (\Illuminate\Database\QueryException $e) {
        // Log the detailed error for debugging, but show a friendly page without failing
        \Log::error('Database connection failed on homepage: ' . $e->getMessage());

        // Fallback empty collections / zeros so the page can render
        $recents = collect();
        $actualites = collect();
        $populaires = collect();
        $totalContenus = 0;
        $totalRegions = 0;
        $totalLangues = 0;
        $totalUtilisateurs = 0;

        // Optionally pass a flag to the view so it can show a soft warning
        return view('welcome', compact('actualites', 'recents', 'populaires', 'totalContenus', 'totalRegions', 'totalLangues', 'totalUtilisateurs'))->with('db_error', true);
    }
})->name('accueil');

// API-like endpoint to return live totals (used by homepage counters)
Route::get('/stats', function () {
    $totalContenus = \App\Models\Contenu::approuves()->count();
    $totalRegions = \App\Models\Region::count();
    $totalLangues = \App\Models\Langue::count();
    $totalUtilisateurs = \App\Models\Utilisateur::count();

    return response()->json([
        'contenus' => $totalContenus,
        'regions' => $totalRegions,
        'langues' => $totalLangues,
        'utilisateurs' => $totalUtilisateurs,
    ]);
})->name('stats');

// Serve images placed in resources/images through a simple route (so authors can keep images in resources)
// If the requested file is missing, return a small generated SVG placeholder so the poster doesn't break.
Route::get('/images/{filename}', function ($filename) {
    $allowed = ['hero.jpg', 'hero.png', 'hero.webp'];
    if (!in_array($filename, $allowed)) {
        abort(404);
    }
    $path = resource_path('images/' . $filename);
    if (file_exists($path)) {
        return response()->file($path, ['Cache-Control' => 'public, max-age=86400']);
    }

    // Fallback: generate a lightweight SVG placeholder (works even without an actual image file)
    $label = htmlspecialchars(pathinfo($filename, PATHINFO_FILENAME), ENT_QUOTES, 'UTF-8');
    $svg = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
        "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"1600\" height=\"900\" viewBox=\"0 0 1600 900\">" .
        "<defs><linearGradient id=\"g\" x1=\"0%\" x2=\"100%\" y1=\"0%\" y2=\"100%\"><stop offset=\"0%\" stop-color=\"#f7f7f7\"/><stop offset=\"100%\" stop-color=\"#e6eef0\"/></linearGradient></defs>" .
        "<rect width=\"100%\" height=\"100%\" fill=\"url(#g)\"/>" .
        "<text x=\"50%\" y=\"48%\" font-family=\"sans-serif\" font-size=\"42\" fill=\"#333\" text-anchor=\"middle\">Placeholder</text>" .
        "<text x=\"50%\" y=\"58%\" font-family=\"sans-serif\" font-size=\"28\" fill=\"#666\" text-anchor=\"middle\">{$label}</text>" .
        "</svg>";

    return response($svg, 200, ['Content-Type' => 'image/svg+xml', 'Cache-Control' => 'public, max-age=3600']);
});

// Pages statiques
Route::redirect('/about', '/a-propos');
Route::get('/a-propos', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Pages 'Découvrir' - placeholder routes to avoid 404s from the header links
Route::get('/decouvrir/{slug}', function ($slug) {
    $mapping = [
        'art-et-artisanat' => 'Art & Artisanat',
        'musique-danse' => 'Musique & Danse',
        'gastronomie' => 'Gastronomie',
    ];

    if (!array_key_exists($slug, $mapping)) {
        abort(404);
    }

    $title = $mapping[$slug];
    // If a dedicated view exists for certain slugs, return it directly
    if ($slug === 'gastronomie' && view()->exists('decouvrir.gastronomie')) {
        return view('decouvrir.gastronomie');
    }

    if ($slug === 'musique-danse' && view()->exists('decouvrir.musique-danse')) {
        return view('decouvrir.musique-danse');
    }

    return view('decouvrir.show', compact('title', 'slug'));
})->name('decouvrir.show');

// Dedicated gastronomic page
Route::get('/gastronomie', function () {
    return view('decouvrir.gastronomie');
})->name('gastronomie');

// Place an order (simple flow: store order and return a payment URL simulation)
use App\Models\Order;
use Illuminate\Http\Request;

Route::post('/gastronomie/order', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
        'address' => 'nullable|string|max:2000',
        'items' => 'required|array|min:1',
        'total' => 'required|numeric|min:0',
    ]);

    try {
        $order = Order::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'items' => $data['items'],
            'total' => $data['total'],
            'paid' => false,
        ]);

        // Simulate a payment URL: in real usage integrate Stripe/PayPal/MoMo here
        $paymentUrl = url('/gastronomie/payment/' . $order->id);

        return response()->json(['ok' => true, 'payment_url' => $paymentUrl]);
    } catch (\Exception $e) {
        \Log::error('Gastronomie order error: ' . $e->getMessage());
        return response()->json(['ok' => false, 'error' => 'unable_to_create_order'], 500);
    }
})->name('gastronomie.order');

// Simulated payment endpoint — marks order as paid and shows a simple confirmation
Route::get('/gastronomie/payment/{order}', function (Order $order) {
    try {
        $order->update(['paid' => true, 'payment_provider' => 'simulated', 'payment_reference' => 'SIM-' . strtoupper(uniqid())]);
    } catch (\Exception $e) {
        \Log::warning('Payment simulation failed: '.$e->getMessage());
    }

    return view('decouvrir.gastronomie_payment', compact('order'));
})->name('gastronomie.payment');

// Public sections/pages
Route::get('/artisans', function () {
    return view('pages.artisans');
})->middleware(['auth'])->name('artisans');

// Artisan profile (static mapping)
Route::get('/artisans/{slug}', function ($slug) {
    $artisans = [
        ['slug' => 'adjani-k', 'nom' => 'Adjani K.', 'metier' => 'Tisserand traditionnel', 'region' => 'Parakou', 'telephone' => '+229 90 00 00 01', 'description' => "Spécialisé dans les pagnes traditionnels en coton teint à la main (batik et indigot). Travaille avec des motifs locaux transmis par sa famille.", 'image' => 'https://images.unsplash.com/photo-1520975915143-8d5c2f0a2f8b?auto=format&fit=crop&w=800&q=60'],
        ['slug' => 'fatoumata-s', 'nom' => 'Fatoumata S.', 'metier' => 'Sculptrice sur bois', 'region' => 'Abomey', 'telephone' => '+229 90 00 00 02', 'description' => "Créations d'objets rituels et décoratifs inspirés des traditions du Sud-Bénin. Réalise aussi des ateliers participatifs.", 'image' => 'https://images.unsplash.com/photo-1543866763-9e1a5f8f7a3c?auto=format&fit=crop&w=800&q=60'],
        ['slug' => 'mahoudo-d', 'nom' => 'Mahoudo D.', 'metier' => 'Forgeron et ferronnier', 'region' => 'Cotonou', 'telephone' => '+229 90 00 00 03', 'description' => "Travaille le métal pour créer des instruments de musique et des outils traditionnels. Propose restauration d'objets anciens.", 'image' => 'https://images.unsplash.com/photo-1505765056983-6c9b6a9f5d65?auto=format&fit=crop&w=800&q=60'],
        ['slug' => 'aminata-b', 'nom' => 'Aminata B.', 'metier' => 'Bijoutière (perles et argent)', 'region' => 'Ouidah', 'telephone' => '+229 90 00 00 04', 'description' => "Bijoux contemporains inspirés des perles traditionnelles béninoises, réalisés à la commande.", 'image' => 'https://images.unsplash.com/photo-1520975915143-8d5c2f0a2f8b?auto=format&fit=crop&w=800&q=60'],
    ];

    $artisan = collect($artisans)->firstWhere('slug', $slug);
    if (!$artisan) {
        abort(404);
    }

    return view('pages.artisans.show', ['artisan' => $artisan]);
})->middleware(['auth'])->name('artisans.show');

Route::get('/evenements', function () {
    return view('pages.evenements');
})->middleware(['auth'])->name('evenements');

Route::get('/galerie', function () {
    return view('pages.galerie');
})->middleware(['auth'])->name('galerie');

use App\Http\Controllers\MediaController;

Route::get('/galerie', [MediaController::class, 'index'])->middleware(['auth'])->name('galerie');
Route::get('/galerie/upload', [MediaController::class, 'create'])->middleware(['auth'])->name('galerie.upload');
Route::post('/galerie/upload', [MediaController::class, 'store'])->middleware(['auth'])->name('galerie.store');
Route::get('/galerie/{media}', [MediaController::class, 'show'])->middleware(['auth'])->name('galerie.show');

use App\Http\Controllers\ExplorerController;

Route::get('/explorer', [ExplorerController::class, 'index'])->middleware(['auth'])->name('explorer');
Route::get('/explorer/{slug}', [ExplorerController::class, 'show'])->middleware(['auth'])->name('explorer.show');

Route::get('/communaute', function () {
    try {
        $artisans = Utilisateur::orderBy('date_inscription','desc')->take(6)->get();
        $featured = Contenu::approuves()->orderBy('date_creation','desc')->take(6)->get();
    } catch (\Illuminate\Database\QueryException $e) {
        \Log::warning('Unable to fetch artisans/featured for community page: '.$e->getMessage());
        $artisans = collect();
        $featured = collect();
    }

    return view('pages.communaute', compact('artisans', 'featured'));
})->name('communaute');

// Newsletter subscription endpoint (stores email)
Route::post('/newsletter/subscribe', function (\Illuminate\Http\Request $request) {
    $data = $request->validate(['email' => 'required|email|max:255']);
    try {
        \App\Models\Newsletter::create(['email' => $data['email']]);
        return response()->json(['ok' => true]);
    } catch (\Exception $e) {
        \Log::error('Newsletter subscribe error: '.$e->getMessage());
        return response()->json(['ok' => false], 500);
    }
})->name('newsletter.subscribe');

// Traitement du formulaire de contact (simple: envoi d'email ou stockage)
Route::post('/contact/send', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|max:5000',
    ]);

    // Pour l'instant on enregistre le message dans le journal (log).
    \Log::info('Contact form submitted', $data);

    return redirect()->route('contact')->with('success', 'Merci, votre message a été envoyé.');
})->name('contact.send');

// Routes de paiement pour les événements
Route::get('/evenements/{eventSlug}/paiement', [EventPaymentController::class, 'show'])->name('event.payment.show');
Route::post('/evenements/{eventSlug}/paiement', [EventPaymentController::class, 'process'])->name('event.payment.process');
Route::get('/evenements/{eventSlug}/paiement/{paymentId}/verifier', [EventPaymentController::class, 'verify'])->name('event.payment.verify');
Route::match(['get','post'], '/evenements/paiement/kkiapay/callback', [EventPaymentController::class, 'kkiapayCallback'])->name('event.payment.kkiapay.callback');
Route::get('/evenements/{eventSlug}/details', [EventPaymentController::class, 'details'])->name('event.details');

// Dashboard différencié selon le rôle
Route::get('/dashboard', function () {
    // Admin, Modérateur et Contributeur : tableau de bord admin complet
    // Les contributeurs voient le même dashboard que les modérateurs,
    // les actions de création/suppression restent néanmoins restreintes
    if (Auth::user()->isAdmin() || Auth::user()->isModerator() || Auth::user()->isContributor()) {
        $stats = [
            'total_users' => \App\Models\Utilisateur::count(),
            'total_contenus' => \App\Models\Contenu::count(),
            'total_regions' => \App\Models\Region::count(),
            'total_langues' => \App\Models\Langue::count(),
            'contenus_par_type' => \App\Models\TypeContenu::withCount('contenus')->get()
        ];

        $recentUsers = \App\Models\Utilisateur::with('role')
            ->orderBy('date_inscription', 'desc')
            ->take(5)
            ->get();
        
        $recentContenus = \App\Models\Contenu::with(['region', 'typeContenu', 'auteur'])
            ->orderBy('date_creation', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentContenus'));
    }

    // Utilisateur standard
    $userStats = [
        'mes_contenus' => \App\Models\Contenu::where('id_auteur', Auth::id())->count(),
        'contenus_en_attente' => \App\Models\Contenu::where('id_auteur', Auth::id())->where('statut', 'en_attente')->count(),
        'contenus_approuves' => \App\Models\Contenu::where('id_auteur', Auth::id())->where('statut', 'valide')->count()
    ];

    $recentUserContenus = \App\Models\Contenu::with(['region', 'typeContenu'])
        ->where('id_auteur', Auth::id())
        ->orderBy('date_creation', 'desc')
        ->take(5)
        ->get();

    return view('user.dashboard', compact('userStats', 'recentUserContenus'));
})->middleware(['auth'])->name('dashboard');

// Route pour les statistiques détaillées (Admin seulement)
Route::get('/admin/statistiques', function () {
    if (!Auth::user()->isAdmin()) {
        abort(403, 'Accès non autorisé.');
    }
    
    $stats = [
        'users_par_role' => \App\Models\Role::withCount('utilisateurs')->get(),
        'contenus_par_region' => \App\Models\Region::withCount('contenus')->get(),
        'contenus_par_mois' => \App\Models\Contenu::selectRaw('MONTH(date_creation) as mois, COUNT(*) as count')
            ->groupBy('mois')
            ->get()
    ];
    
    return view('admin.statistiques', compact('stats'));
})->middleware(['auth'])->name('admin.statistiques');

Route::middleware('auth')->group(function () {
    // User Dashboard route (événements payés, plats payés, paramètres)
    Route::get('/mon-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Routes publiques pour tous les utilisateurs authentifiés
    Route::get('/contenus', function () {
        $contenus = \App\Models\Contenu::with(['region', 'langue', 'typeContenu', 'auteur'])
            ->where('statut', 'valide')
            ->orderBy('date_creation', 'desc')
            ->paginate(10);
        
        return view('contenus.index', compact('contenus'));
    })->name('contenus.index');
    
    Route::get('/contenus/create', function () {
        $regions = \App\Models\Region::all();
        $langues = \App\Models\Langue::all();
        $typeContenus = \App\Models\TypeContenu::all();
        
        return view('contenus.create', compact('regions', 'langues', 'typeContenus'));
    })->name('contenus.create');
    
    Route::post('/contenus', [ContenuController::class, 'storePublic'])->name('contenus.store');
    
    Route::get('/regions', function () {
        $regions = \App\Models\Region::withCount('contenus')
            ->orderBy('nom_region')
            ->paginate(10);
        
        return view('regions.index', compact('regions'));
    })->name('regions.index');
    
    Route::get('/langues', function () {
        $langues = \App\Models\Langue::withCount('contenus')
            ->orderBy('nom_langue')
            ->paginate(10);
        
        return view('langues.index', compact('langues'));
    })->name('langues.index');
    
    Route::get('/mes-contenus', function () {
        // Check if the medias table has the linking column to avoid runtime SQL errors
        $mediasSupported = false;
        try {
            $mediasSupported = \Illuminate\Support\Facades\Schema::hasTable('medias') && \Illuminate\Support\Facades\Schema::hasColumn('medias', 'id_contenu');
        } catch (\Exception $e) {
            $mediasSupported = false;
        }

        $query = \App\Models\Contenu::with(['region', 'langue', 'typeContenu']);
        if ($mediasSupported) {
            $query = $query->with('medias');
        }

        $contenus = $query->where('id_auteur', auth()->id())
            ->orderBy('date_creation', 'desc')
            ->paginate(10);

        return view('mes-contenus.index', compact('contenus', 'mediasSupported'));
    })->name('mes-contenus');

    // Allow authors to delete their own contenus (soft check: author or admin)
    Route::delete('/mes-contenus/{contenu}', [\App\Http\Controllers\Admin\ContenuController::class, 'destroyOwner'])
        ->middleware('auth')
        ->name('mes-contenus.destroy');

    // Allow contributors to delete their own uploaded media (files + db record)
    Route::delete('/media/{media}/delete', [\App\Http\Controllers\MediaController::class, 'destroy'])
        ->middleware('auth')
        ->name('media.user.destroy');

    // Profil public (affichage d'un utilisateur)
    Route::get('/utilisateur/{utilisateur}', function (\App\Models\Utilisateur $utilisateur) {
        return view('profil.show', compact('utilisateur'));
    })->name('utilisateur.show');
});

// Routes d'administration avec préfixe - VERSION SIMPLIFIÉE
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // === UTILISATEURS (Admin seulement) ===
    Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->middleware('role:admin')->name('utilisateurs.index');
    Route::get('/utilisateurs/create', [UtilisateurController::class, 'create'])->middleware('role:admin')->name('utilisateurs.create');
    Route::post('/utilisateurs', [UtilisateurController::class, 'store'])->middleware('role:admin')->name('utilisateurs.store');
    Route::get('/utilisateurs/{utilisateur}', [UtilisateurController::class, 'show'])->middleware('role:admin')->name('utilisateurs.show');
    Route::get('/utilisateurs/{utilisateur}/edit', [UtilisateurController::class, 'edit'])->middleware('role:admin')->name('utilisateurs.edit');
    Route::put('/utilisateurs/{utilisateur}', [UtilisateurController::class, 'update'])->middleware('role:admin')->name('utilisateurs.update');
    Route::delete('/utilisateurs/{utilisateur}', [UtilisateurController::class, 'destroy'])->middleware('role:admin')->name('utilisateurs.destroy');

    // === CONTENUS (Admin + Modérateur en écriture, Contributeur en lecture seule) ===
    Route::get('/contenus', [ContenuController::class, 'index'])->middleware('role:admin,moderator,contributor')->name('contenus.index');
    Route::get('/contenus/create', [ContenuController::class, 'create'])->middleware('role:admin,moderator')->name('contenus.create');
    Route::post('/contenus', [ContenuController::class, 'store'])->middleware('role:admin,moderator')->name('contenus.store');
    Route::get('/contenus/{contenu}', [ContenuController::class, 'show'])->middleware('role:admin,moderator,contributor')->name('contenus.show');
    Route::get('/contenus/{contenu}/edit', [ContenuController::class, 'edit'])->middleware('role:admin,moderator')->name('contenus.edit');
    Route::put('/contenus/{contenu}', [ContenuController::class, 'update'])->middleware('role:admin,moderator')->name('contenus.update');
    Route::delete('/contenus/{contenu}', [ContenuController::class, 'destroy'])->middleware('role:admin')->name('contenus.destroy');
    
    // Validation des contenus (admin + moderator)
    Route::post('/contenus/{contenu}/valider', [ContenuController::class, 'valider'])->middleware('role:admin,moderator')->name('contenus.valider');
    Route::post('/contenus/{contenu}/rejeter', [ContenuController::class, 'rejeter'])->middleware('role:admin,moderator')->name('contenus.rejeter');

    // === RÉGIONS (Admin + Modérateur en écriture, Contributeur en lecture seule) ===
    Route::get('/regions', [RegionController::class, 'index'])->middleware('role:admin,moderator,contributor')->name('regions.index');
    Route::get('/regions/create', [RegionController::class, 'create'])->middleware('role:admin,moderator')->name('regions.create');
    Route::post('/regions', [RegionController::class, 'store'])->middleware('role:admin,moderator')->name('regions.store');
    Route::get('/regions/{region}', [RegionController::class, 'show'])->middleware('role:admin,moderator,contributor')->name('regions.show');
    Route::get('/regions/{region}/edit', [RegionController::class, 'edit'])->middleware('role:admin,moderator')->name('regions.edit');
    Route::put('/regions/{region}', [RegionController::class, 'update'])->middleware('role:admin,moderator')->name('regions.update');
    Route::delete('/regions/{region}', [RegionController::class, 'destroy'])->middleware('role:admin')->name('regions.destroy');

    // === LANGUES (Admin + Modérateur + Contributeur en lecture) ===
    Route::get('/langues', [LangueController::class, 'index'])->middleware('role:admin,moderator,contributor')->name('langues.index');
    Route::get('/langues/create', [LangueController::class, 'create'])->middleware('role:admin,moderator')->name('langues.create');
    Route::post('/langues', [LangueController::class, 'store'])->middleware('role:admin,moderator')->name('langues.store');
    Route::get('/langues/{langue}', [LangueController::class, 'show'])->middleware('role:admin,moderator,contributor')->name('langues.show');
    Route::get('/langues/{langue}/edit', [LangueController::class, 'edit'])->middleware('role:admin,moderator')->name('langues.edit');
    Route::put('/langues/{langue}', [LangueController::class, 'update'])->middleware('role:admin,moderator')->name('langues.update');
    Route::delete('/langues/{langue}', [LangueController::class, 'destroy'])->middleware('role:admin')->name('langues.destroy');

    // === CONFIGURATION (Admin seulement) ===
    // RÔLES
    Route::get('/roles', [RoleController::class, 'index'])->middleware('role:admin')->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->middleware('role:admin')->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->middleware('role:admin')->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->middleware('role:admin')->name('roles.show');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->middleware('role:admin')->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('role:admin')->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('role:admin')->name('roles.destroy');

    // TYPES DE CONTENU
    Route::get('/type-contenus', [TypeContenuController::class, 'index'])->middleware('role:admin,moderator,contributor')->name('type-contenus.index');
    Route::get('/type-contenus/create', [TypeContenuController::class, 'create'])->middleware('role:admin,moderator')->name('type-contenus.create');
    Route::post('/type-contenus', [TypeContenuController::class, 'store'])->middleware('role:admin,moderator')->name('type-contenus.store');
    Route::get('/type-contenus/{typeContenu}', [TypeContenuController::class, 'show'])->middleware('role:admin,moderator,contributor')->name('type-contenus.show');
    Route::get('/type-contenus/{typeContenu}/edit', [TypeContenuController::class, 'edit'])->middleware('role:admin,moderator')->name('type-contenus.edit');
    Route::put('/type-contenus/{typeContenu}', [TypeContenuController::class, 'update'])->middleware('role:admin,moderator')->name('type-contenus.update');
    Route::delete('/type-contenus/{typeContenu}', [TypeContenuController::class, 'destroy'])->middleware('role:admin')->name('type-contenus.destroy');

    // TYPES DE MEDIA
    Route::get('/type-media', [TypeMediaController::class, 'index'])->middleware('role:admin,moderator,contributor')->name('type-media.index');
    Route::get('/type-media/create', [TypeMediaController::class, 'create'])->middleware('role:admin,moderator')->name('type-media.create');
    Route::post('/type-media', [TypeMediaController::class, 'store'])->middleware('role:admin,moderator')->name('type-media.store');
    Route::get('/type-media/{typeMedia}', [TypeMediaController::class, 'show'])->middleware('role:admin,moderator,contributor')->name('type-media.show');
    Route::get('/type-media/{typeMedia}/edit', [TypeMediaController::class, 'edit'])->middleware('role:admin,moderator')->name('type-media.edit');
    Route::put('/type-media/{typeMedia}', [TypeMediaController::class, 'update'])->middleware('role:admin,moderator')->name('type-media.update');
    Route::delete('/type-media/{typeMedia}', [TypeMediaController::class, 'destroy'])->middleware('role:admin')->name('type-media.destroy');

    // MEDIAS
    Route::get('/media', [MediaController::class, 'index'])->middleware('role:admin,moderator,contributor')->name('media.index');
    Route::get('/media/create', [MediaController::class, 'create'])->middleware('role:admin,moderator')->name('media.create');
    Route::post('/media', [MediaController::class, 'store'])->middleware('role:admin,moderator')->name('media.store');
    Route::get('/media/{media}', [MediaController::class, 'show'])->middleware('role:admin,moderator,contributor')->name('media.show');
    Route::get('/media/{media}/edit', [MediaController::class, 'edit'])->middleware('role:admin,moderator')->name('media.edit');
    Route::put('/media/{media}', [MediaController::class, 'update'])->middleware('role:admin,moderator')->name('media.update');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->middleware('role:admin')->name('media.destroy');

    // COMMENTAIRES
    Route::get('/commentaires', [CommentaireController::class, 'index'])->middleware('role:admin,moderator,contributor')->name('commentaires.index');
    Route::get('/commentaires/create', [CommentaireController::class, 'create'])->middleware('role:admin,moderator')->name('commentaires.create');
    Route::post('/commentaires', [CommentaireController::class, 'store'])->middleware('role:admin,moderator')->name('commentaires.store');
    Route::get('/commentaires/{commentaire}', [CommentaireController::class, 'show'])->middleware('role:admin,moderator,contributor')->name('commentaires.show');
    Route::get('/commentaires/{commentaire}/edit', [CommentaireController::class, 'edit'])->middleware('role:admin,moderator')->name('commentaires.edit');
    Route::put('/commentaires/{commentaire}', [CommentaireController::class, 'update'])->middleware('role:admin,moderator')->name('commentaires.update');
    Route::delete('/commentaires/{commentaire}', [CommentaireController::class, 'destroy'])->middleware('role:admin')->name('commentaires.destroy');

    // PARLER (Relations Régions-Langues)
    Route::get('/parler', [ParlerController::class, 'index'])->middleware('role:admin,moderator,contributor')->name('parler.index');
    Route::get('/parler/create', [ParlerController::class, 'create'])->middleware('role:admin,moderator')->name('parler.create');
    Route::post('/parler', [ParlerController::class, 'store'])->middleware('role:admin,moderator')->name('parler.store');
    Route::get('/parler/{parler}', [ParlerController::class, 'show'])->middleware('role:admin,moderator,contributor')->name('parler.show');
    Route::get('/parler/{parler}/edit', [ParlerController::class, 'edit'])->middleware('role:admin,moderator')->name('parler.edit');
    Route::put('/parler/{parler}', [ParlerController::class, 'update'])->middleware('role:admin,moderator')->name('parler.update');
    Route::delete('/parler/{parler}', [ParlerController::class, 'destroy'])->middleware('role:admin')->name('parler.destroy');
});

require __DIR__.'/auth.php';

// Route pour servir les fichiers de profil
Route::get('/profile-photo/{filename}', function ($filename) {
    $path = storage_path('app/public/profiles/' . $filename);
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
})->name('profile.photo');

// Chargement routes supplémentaires (événements, etc.)
if (file_exists(__DIR__ . '/events_routes.php')) {
    require __DIR__ . '/events_routes.php';
}