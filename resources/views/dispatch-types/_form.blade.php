<div class="card-body">
    <div class="form-group">
        <label for="name">Nombre <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
               value="{{ old('name', $dispatchType->name ?? '') }}" placeholder="Ej: Chilexpress" required>
        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="custom-control custom-switch">
        <input type="hidden" name="requires_address" value="0">
        <input type="checkbox" class="custom-control-input" id="requires_address" name="requires_address" value="1"
               {{ old('requires_address', $dispatchType->requires_address ?? true) ? 'checked' : '' }}>
        <label class="custom-control-label" for="requires_address">Requiere dirección de despacho</label>
        <small class="form-text text-muted">Desmarque esta opción para alternativas como “Retiro en tienda”.</small>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
    <a href="{{ route('admin.dispatch-types.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
</div>
