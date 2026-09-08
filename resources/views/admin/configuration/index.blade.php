@extends('adminlte::page')

@section('title', 'Configuración del Sistema')

@section('content_header')
    <h1>
        <i class="fas fa-cogs"></i> Configuración del Sistema
        <small>Personaliza la apariencia y configuración</small>
    </h1>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Errores de validación:</h5>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.configuration.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Branding -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-paint-brush"></i> Marca y Identidad</h3>
                    </div>
                    <div class="card-body">
                        <!-- Company Name -->
                        <div class="form-group">
                            <label for="company_name">Nombre de la Empresa</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" 
                                   value="{{ old('company_name', $configurations['branding']->where('key', 'company_name')->first()->value ?? '') }}"
                                   placeholder="Mi Empresa">
                        </div>

                        <!-- Company Tagline -->
                        <div class="form-group">
                            <label for="company_tagline">Eslogan de la Empresa</label>
                            <input type="text" class="form-control" id="company_tagline" name="company_tagline" 
                                   value="{{ old('company_tagline', $configurations['branding']->where('key', 'company_tagline')->first()->value ?? '') }}"
                                   placeholder="Tu mejor opción">
                        </div>

                        <!-- Logo -->
                        <div class="form-group">
                            <label for="logo">Logo de la Empresa</label>
                            @php
                                $currentLogo = $configurations['branding']->where('key', 'logo')->first();
                            @endphp
                            @if($currentLogo && $currentLogo->value)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($currentLogo->value) }}" alt="Logo actual" class="img-thumbnail" style="max-height: 100px;">
                                    <small class="text-muted d-block">Logo actual</small>
                                </div>
                            @endif
                            <input type="file" class="form-control-file" id="logo" name="logo" accept="image/*">
                            <small class="form-text text-muted">Formatos: JPG, PNG, GIF, SVG. Tamaño máximo: 2MB</small>
                        </div>

                        <!-- Favicon -->
                        <div class="form-group">
                            <label for="favicon">Favicon</label>
                            @php
                                $currentFavicon = $configurations['branding']->where('key', 'favicon')->first();
                            @endphp
                            @if($currentFavicon && $currentFavicon->value)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($currentFavicon->value) }}" alt="Favicon actual" class="img-thumbnail" style="max-height: 32px;">
                                    <small class="text-muted d-block">Favicon actual</small>
                                </div>
                            @endif
                            <input type="file" class="form-control-file" id="favicon" name="favicon" accept=".ico,.png">
                            <small class="form-text text-muted">Formatos: ICO, PNG. Tamaño máximo: 512KB</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appearance -->
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-palette"></i> Apariencia y Colores</h3>
                    </div>
                    <div class="card-body">
                        <!-- Primary Color -->
                        <div class="form-group">
                            <label for="primary_color">Color Primario</label>
                            <div class="input-group">
                                <input type="color" class="form-control" id="primary_color" name="primary_color" 
                                       value="{{ old('primary_color', $configurations['appearance']->where('key', 'primary_color')->first()->value ?? '#007bff') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ old('primary_color', $configurations['appearance']->where('key', 'primary_color')->first()->value ?? '#007bff') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Secondary Color -->
                        <div class="form-group">
                            <label for="secondary_color">Color Secundario</label>
                            <div class="input-group">
                                <input type="color" class="form-control" id="secondary_color" name="secondary_color" 
                                       value="{{ old('secondary_color', $configurations['appearance']->where('key', 'secondary_color')->first()->value ?? '#6c757d') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ old('secondary_color', $configurations['appearance']->where('key', 'secondary_color')->first()->value ?? '#6c757d') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Accent Color -->
                        <div class="form-group">
                            <label for="accent_color">Color de Acento</label>
                            <div class="input-group">
                                <input type="color" class="form-control" id="accent_color" name="accent_color" 
                                       value="{{ old('accent_color', $configurations['appearance']->where('key', 'accent_color')->first()->value ?? '#28a745') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ old('accent_color', $configurations['appearance']->where('key', 'accent_color')->first()->value ?? '#28a745') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Color -->
                        <div class="form-group">
                            <label for="sidebar_color">Color del Sidebar</label>
                            <div class="input-group">
                                <input type="color" class="form-control" id="sidebar_color" name="sidebar_color" 
                                       value="{{ old('sidebar_color', $configurations['appearance']->where('key', 'sidebar_color')->first()->value ?? '#343a40') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ old('sidebar_color', $configurations['appearance']->where('key', 'sidebar_color')->first()->value ?? '#343a40') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- General Settings -->
            <div class="col-md-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cog"></i> Configuración General</h3>
                    </div>
                    <div class="card-body">
                        <!-- System Name -->
                        <div class="form-group">
                            <label for="system_name">Nombre del Sistema</label>
                            <input type="text" class="form-control" id="system_name" name="system_name" 
                                   value="{{ old('system_name', $configurations['general']->where('key', 'system_name')->first()->value ?? '') }}"
                                   placeholder="Sistema POS">
                        </div>

                        <!-- Footer Text -->
                        <div class="form-group">
                            <label for="footer_text">Texto del Footer</label>
                            <input type="text" class="form-control" id="footer_text" name="footer_text" 
                                   value="{{ old('footer_text', $configurations['general']->where('key', 'footer_text')->first()->value ?? '') }}"
                                   placeholder="© 2025 Sistema POS. Todos los derechos reservados.">
                        </div>

                        <!-- Timezone -->
                        <div class="form-group">
                            <label for="timezone">Zona Horaria</label>
                            <select class="form-control" id="timezone" name="timezone">
                                <option value="America/Santiago" {{ old('timezone', $configurations['general']->where('key', 'timezone')->first()->value ?? '') == 'America/Santiago' ? 'selected' : '' }}>Santiago (Chile)</option>
                                <option value="America/Buenos_Aires" {{ old('timezone', $configurations['general']->where('key', 'timezone')->first()->value ?? '') == 'America/Buenos_Aires' ? 'selected' : '' }}>Buenos Aires (Argentina)</option>
                                <option value="America/Lima" {{ old('timezone', $configurations['general']->where('key', 'timezone')->first()->value ?? '') == 'America/Lima' ? 'selected' : '' }}>Lima (Perú)</option>
                                <option value="America/Bogota" {{ old('timezone', $configurations['general']->where('key', 'timezone')->first()->value ?? '') == 'America/Bogota' ? 'selected' : '' }}>Bogotá (Colombia)</option>
                                <option value="America/Mexico_City" {{ old('timezone', $configurations['general']->where('key', 'timezone')->first()->value ?? '') == 'America/Mexico_City' ? 'selected' : '' }}>Ciudad de México</option>
                            </select>
                        </div>

                        <!-- Currency Symbol -->
                        <div class="form-group">
                            <label for="currency_symbol">Símbolo de Moneda</label>
                            <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" 
                                   value="{{ old('currency_symbol', $configurations['general']->where('key', 'currency_symbol')->first()->value ?? '') }}"
                                   placeholder="$" maxlength="5">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-toggle-on"></i> Características del Sistema</h3>
                    </div>
                    <div class="card-body">
                        <!-- Enable WhatsApp -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="enable_whatsapp" name="enable_whatsapp" 
                                       {{ old('enable_whatsapp', $configurations['features']->where('key', 'enable_whatsapp')->first()->value ?? '1') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="enable_whatsapp">Habilitar WhatsApp</label>
                            </div>
                            <small class="form-text text-muted">Permite generar mensajes de WhatsApp desde el catálogo</small>
                        </div>

                        <!-- Enable Catalog -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="enable_catalog" name="enable_catalog" 
                                       {{ old('enable_catalog', $configurations['features']->where('key', 'enable_catalog')->first()->value ?? '1') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="enable_catalog">Habilitar Catálogo Público</label>
                            </div>
                            <small class="form-text text-muted">Permite acceso público al catálogo de productos</small>
                        </div>

                        <!-- Maintenance Mode -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="maintenance_mode" name="maintenance_mode" 
                                       {{ old('maintenance_mode', $configurations['features']->where('key', 'maintenance_mode')->first()->value ?? '0') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="maintenance_mode">Modo Mantenimiento</label>
                            </div>
                            <small class="form-text text-muted text-warning">⚠️ Deshabilitará el acceso público al sistema</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> Los cambios de colores se aplicarán después de guardar. Es posible que necesites refrescar la página para verlos completamente.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Configuraciones
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-lg ml-2">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    .form-control[type="color"] {
        width: 80px;
        height: 38px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        padding: 0;
    }
    
    .input-group-text {
        font-family: monospace;
        font-size: 12px;
        min-width: 80px;
    }
    
    .custom-control-label {
        font-weight: 500;
    }
    
    .card-title i {
        margin-right: 8px;
    }
    
    .img-thumbnail {
        border: 2px solid #dee2e6;
    }
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Update color display when color input changes
    $('input[type="color"]').on('change input', function() {
        const colorValue = $(this).val();
        $(this).closest('.input-group').find('.input-group-text').text(colorValue);
    });
    
    // Preview logo/favicon when selected
    $('input[type="file"]').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = $(this).siblings('.img-thumbnail');
            
            reader.onload = function(e) {
                if (preview.length) {
                    preview.attr('src', e.target.result);
                } else {
                    const img = $('<img>').addClass('img-thumbnail mt-2').attr('src', e.target.result).css('max-height', '100px');
                    $(this).after(img);
                }
            }.bind(this);
            
            reader.readAsDataURL(file);
        }
    });
});
</script>
@stop