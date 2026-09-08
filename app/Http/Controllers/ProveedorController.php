<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('admin.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:proveedores',
            'descripcion' => 'nullable',
            'contacto' => 'nullable|max:255',
            'telefono' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable'
        ]);

        Proveedor::create($request->all());

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        return view('admin.proveedores.show', compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedor)
    {
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:proveedores,nombre,' . $proveedor->id,
            'descripcion' => 'nullable',
            'contacto' => 'nullable|max:255',
            'telefono' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable'
        ]);

        $proveedor->update($request->all());

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }

    /**
     * Toggle proveedor status
     */
    public function toggleStatus(Proveedor $proveedor)
    {
        $proveedor->update(['activo' => !$proveedor->activo]);
        
        $status = $proveedor->activo ? 'activado' : 'desactivado';
        return redirect()->route('admin.proveedores.index')->with('success', "Proveedor {$status} exitosamente.");
    }
}
