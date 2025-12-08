<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Display user dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer les événements payés par l'utilisateur
        $paidEvents = [];
        if (isset($user->paid_events)) {
            $paidEvents = json_decode($user->paid_events, true) ?? [];
        }
        
        // Récupérer les plats payés par l'utilisateur
        $paidDishes = [];
        if (isset($user->paid_dishes)) {
            $paidDishes = json_decode($user->paid_dishes, true) ?? [];
        }
        
        return view('dashboard.user', [
            'user' => $user,
            'paidEvents' => $paidEvents,
            'paidDishes' => $paidDishes,
        ]);
    }
}
