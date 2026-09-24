<?php

namespace App\Http\Controllers;

use App\Models\DispatchType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DispatchTypeController extends Controller
{
    public function index()
    {
        $dispatchTypes = DispatchType::withCount('sales')->orderBy('name')->get();

        return view('dispatch-types.index', compact('dispatchTypes'));
    }

    public function create()
    {
        return view('dispatch-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:dispatch_types,name'],
            'requires_address' => ['nullable', 'boolean'],
        ]);

        DispatchType::create([
            'name' => $data['name'],
            'requires_address' => $request->boolean('requires_address'),
            'active' => true,
        ]);

        return redirect()->route('admin.dispatch-types.index')->with('success', 'Tipo de despacho creado exitosamente.');
    }

    public function edit(DispatchType $dispatchType)
    {
        return view('dispatch-types.edit', compact('dispatchType'));
    }

    public function update(Request $request, DispatchType $dispatchType)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('dispatch_types')->ignore($dispatchType)],
            'requires_address' => ['nullable', 'boolean'],
        ]);

        $dispatchType->update([
            'name' => $data['name'],
            'requires_address' => $request->boolean('requires_address'),
        ]);

        return redirect()->route('admin.dispatch-types.index')->with('success', 'Tipo de despacho actualizado exitosamente.');
    }

    public function toggleStatus(DispatchType $dispatchType)
    {
        $dispatchType->update(['active' => ! $dispatchType->active]);

        return redirect()->route('admin.dispatch-types.index')->with('success', 'Estado del tipo de despacho actualizado.');
    }

    public function destroy(DispatchType $dispatchType)
    {
        if ($dispatchType->sales()->exists()) {
            return redirect()->route('admin.dispatch-types.index')
                ->with('error', 'No se puede eliminar porque está asociado a ventas. Puede desactivarlo.');
        }

        $dispatchType->delete();

        return redirect()->route('admin.dispatch-types.index')->with('success', 'Tipo de despacho eliminado exitosamente.');
    }
}
