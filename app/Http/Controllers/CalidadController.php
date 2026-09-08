<?php

namespace App\Http\Controllers;

use App\Models\Calidad;
use Illuminate\Http\Request;

class CalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calidades = Calidad::withCount('products')->get();
        return view('calidad.index', compact('calidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('calidad.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:calidad,nombre'
        ]);

        Calidad::create($request->all());

        return redirect()->route('admin.calidad.index')
                        ->with('success', 'Calidad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Calidad $calidad)
    {
        $calidad->load('products');
        return view('calidad.show', compact('calidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calidad $calidad)
    {
        return view('calidad.edit', compact('calidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Calidad $calidad)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:calidad,nombre,' . $calidad->id
        ]);

        $calidad->update($request->all());

        return redirect()->route('admin.calidad.index')
                        ->with('success', 'Calidad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calidad $calidad)
    {
        // Verificar si tiene productos asociados
        if ($calidad->products()->count() > 0) {
            return redirect()->route('admin.calidad.index')
                            ->with('error', 'No se puede eliminar la calidad porque tiene productos asociados.');
        }

        $calidad->delete();

        return redirect()->route('admin.calidad.index')
                        ->with('success', 'Calidad eliminada exitosamente.');
    }
}
