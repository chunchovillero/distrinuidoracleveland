<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'document_type' => 'nullable|max:10',
            'document_number' => 'nullable|max:20'
        ]);

        Customer::create($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $sales = $customer->sales()->with(['seller', 'saleDetails.product'])->latest()->paginate(5);
        return view('customers.show', compact('customer', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'document_type' => 'nullable|max:10',
            'document_number' => 'nullable|max:20'
        ]);

        $customer->update($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Toggle customer status
     */
    public function toggleStatus(Customer $customer)
    {
        $customer->update(['active' => !$customer->active]);
        return redirect()->route('admin.customers.index')->with('success', 'Estado del cliente actualizado.');
    }

    /**
     * Search customers (for AJAX)
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $customers = Customer::where('active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('phone', 'LIKE', "%{$query}%")
                  ->orWhere('document_number', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get();

        return response()->json($customers);
    }
}
