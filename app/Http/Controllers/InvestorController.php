<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $query = Company::with('user')->active();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%')
                  ->orWhere('target_audience', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('sale_type') && $request->sale_type !== 'all') {
            $query->where('sale_type', $request->sale_type);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $featuredCompanies = Company::active()->featured()->with('user')->latest()->take(4)->get();
        $recentCompanies   = $query->latest()->paginate(10);
        $categories        = Company::active()->distinct()->pluck('category')->filter()->sort()->values();

        $myInvestments = $user->investments()->with('company')->latest()->take(5)->get();

        $totalInvested = $user->investments()->sum('amount_invested');
        $activeInvestments = $user->investments()->count();

        return view('investor.dashboard', compact(
            'featuredCompanies',
            'recentCompanies',
            'categories',
            'myInvestments',
            'totalInvested',
            'activeInvestments'
        ));
    }

    public function receivedCompanies()
    {
        $user = Auth::user();
        $invitations = $user->receivedInvitations()
            ->with('company.user', 'entrepreneur')
            ->latest()
            ->paginate(10);

        // Mark as seen
        $user->receivedInvitations()->where('status', 'pending')->update(['status' => 'seen']);

        return view('investor.companies', compact('invitations'));
    }

    public function investments()
    {
        $user = Auth::user();
        $investments = $user->investments()->with('company.user')->latest()->paginate(10);

        $totalInvested = $user->investments()->sum('amount_invested');

        return view('investor.investments', compact('investments', 'totalInvested'));
    }

    public function profile(User $user)
    {
        if (!$user->isInvestor()) {
            abort(404);
        }

        $investments = $user->investments()->with('company')->latest()->get();
        $totalInvested = $user->investments()->sum('amount_invested');

        return view('investor.profile', compact('user', 'investments', 'totalInvested'));
    }

    public function search(Request $request)
    {
        $query = Company::with('user')->active();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('sale_type') && $request->sale_type !== 'all') {
            $query->where('sale_type', $request->sale_type);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $companies = $query->latest()->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('investor.partials.company-cards', compact('companies'))->render(),
                'total' => $companies->total(),
            ]);
        }

        return view('investor.search', compact('companies'));
    }
}
