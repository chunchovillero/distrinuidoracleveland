<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = Seller::paginate(10);
        return view('sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:sellers',
            'phone' => 'nullable|max:20',
            'address' => 'nullable'
        ]);

        Seller::create($request->all());

        return redirect()->route('admin.sellers.index')->with('success', 'Vendedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        $sales = $seller->sales()->with(['customer', 'saleDetails.product'])->latest()->paginate(5);
        $totalCommissions = $seller->totalCommissions();
        return view('sellers.show', compact('seller', 'sales', 'totalCommissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seller $seller)
    {
        return view('sellers.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seller $seller)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:sellers,email,' . $seller->id,
            'phone' => 'nullable|max:20',
            'address' => 'nullable'
        ]);

        $seller->update($request->all());

        return redirect()->route('admin.sellers.index')->with('success', 'Vendedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller)
    {
        $seller->delete();
        return redirect()->route('admin.sellers.index')->with('success', 'Vendedor eliminado exitosamente.');
    }

    /**
     * Toggle seller status
     */
    public function toggleStatus(Seller $seller)
    {
        $seller->update(['active' => !$seller->active]);
        return redirect()->route('admin.sellers.index')->with('success', 'Estado del vendedor actualizado.');
    }
}
