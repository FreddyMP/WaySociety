<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isEntrepreneur()) {
            $companies = $user->companies()->withCount('products', 'investments')->latest()->get();
            return view('entrepreneur.dashboard', compact('companies'));
        }

        // Investor dashboard
        return redirect()->route('investor.dashboard');
    }
}
