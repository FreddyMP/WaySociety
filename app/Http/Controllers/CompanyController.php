<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Auth::user()->companies()->withCount('products', 'investments')->latest()->paginate(10);
        return view('entrepreneur.dashboard', compact('companies'));
    }

    public function create()
    {
        return view('entrepreneur.company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'category'             => 'nullable|string|max:100',
            'location'             => 'nullable|string|max:100',
            'year_founded'         => 'nullable|integer|min:1900|max:' . date('Y'),
            'website'              => 'nullable|url|max:255',
            'contact_email'        => 'nullable|email|max:255',
            'contact_phone'        => 'nullable|string|max:20',
            'description'          => 'nullable|string',
            'target_audience'      => 'nullable|string',
            'business_plan'        => 'nullable|string',
            'sale_type'            => 'required|in:individual,complete',
            'percentage_available' => 'required|numeric|min:0|max:100',
            'price_per_share'      => 'nullable|numeric|min:0',
            'total_shares'         => 'nullable|integer|min:0',
            'company_value'        => 'nullable|numeric|min:0',
            'minimum_investment'   => 'nullable|numeric|min:0',
            'logo'                 => 'nullable|image|max:2048',
            'cover_image'          => 'nullable|image|max:4096',
            'products'             => 'nullable|array',
            'products.*.name'      => 'required_with:products|string|max:255',
        ]);

        $data = $request->except(['logo', 'cover_image', 'products', '_token']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 's3');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 's3');
        }

        $company = Company::create($data);

        // Store products
        if ($request->has('products')) {
            foreach ($request->products as $index => $productData) {
                if (empty($productData['name'])) continue;

                $product = new Product([
                    'name'            => $productData['name'],
                    'description'     => $productData['description'] ?? null,
                    'target_audience' => $productData['target_audience'] ?? null,
                ]);

                if (isset($productData['image']) && $productData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $product->image = $productData['image']->store('products', 's3');
                }

                $company->products()->save($product);
            }
        }

        return redirect()->route('entrepreneur.companies')->with('success', '¡Empresa registrada exitosamente!');
    }

    public function show(Company $company)
    {
        Gate::authorize('view', $company);
        $company->load('products', 'user', 'investments.investor');
        return view('shared.company-show', compact('company'));
    }

    public function edit(Company $company)
    {
        Gate::authorize('update', $company);
        $company->load('products');
        return view('entrepreneur.company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        Gate::authorize('update', $company);

        $request->validate([
            'name'                 => 'required|string|max:255',
            'category'             => 'nullable|string|max:100',
            'location'             => 'nullable|string|max:100',
            'year_founded'         => 'nullable|integer|min:1900|max:' . date('Y'),
            'website'              => 'nullable|url|max:255',
            'contact_email'        => 'nullable|email|max:255',
            'contact_phone'        => 'nullable|string|max:20',
            'description'          => 'nullable|string',
            'target_audience'      => 'nullable|string',
            'business_plan'        => 'nullable|string',
            'sale_type'            => 'required|in:individual,complete',
            'percentage_available' => 'required|numeric|min:0|max:100',
            'price_per_share'      => 'nullable|numeric|min:0',
            'total_shares'         => 'nullable|integer|min:0',
            'company_value'        => 'nullable|numeric|min:0',
            'minimum_investment'   => 'nullable|numeric|min:0',
            'logo'                 => 'nullable|image|max:2048',
            'cover_image'          => 'nullable|image|max:4096',
        ]);

        $data = $request->except(['logo', 'cover_image', '_token', '_method']);

        if ($request->hasFile('logo')) {
            if ($company->logo) Storage::disk('s3')->delete($company->logo);
            $data['logo'] = $request->file('logo')->store('logos', 's3');
        }

        if ($request->hasFile('cover_image')) {
            if ($company->cover_image) Storage::disk('s3')->delete($company->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('covers', 's3');
        }

        $company->update($data);

        return redirect()->route('entrepreneur.companies')->with('success', '¡Empresa actualizada exitosamente!');
    }

    public function destroy(Company $company)
    {
        Gate::authorize('delete', $company);

        if ($company->logo) Storage::disk('s3')->delete($company->logo);
        if ($company->cover_image) Storage::disk('s3')->delete($company->cover_image);

        $company->delete();

        return redirect()->route('entrepreneur.companies')->with('success', 'Empresa eliminada.');
    }

    public function sendToInvestor(Request $request, Company $company)
    {
        Gate::authorize('update', $company);

        $request->validate([
            'investor_id' => 'required|exists:users,id',
            'message'     => 'nullable|string|max:500',
        ]);

        $existing = $company->invitations()
            ->where('investor_id', $request->investor_id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'Ya enviaste esta empresa a ese inversionista.');
        }

        $company->invitations()->create([
            'investor_id'    => $request->investor_id,
            'entrepreneur_id' => Auth::id(),
            'message'        => $request->message,
        ]);

        // Notify investor
        \App\Models\AppNotification::create([
            'user_id' => $request->investor_id,
            'type'    => 'company_invitation',
            'title'   => '¡Nueva empresa disponible!',
            'body'    => Auth::user()->name . ' te ha enviado la empresa: ' . $company->name,
            'data'    => ['company_id' => $company->id],
        ]);

        return back()->with('success', '¡Empresa enviada al inversionista!');
    }
}
