<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Catálogo - ' . ($systemConfig['company_name'] ?? 'Sistema POS'))</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon personalizado -->
    @if(!empty($systemConfig['favicon'] ?? ''))
        <link rel="icon" type="image/x-icon" href="{{ asset($systemConfig['favicon']) }}">
    @endif
    
    <!-- Estilos personalizados del sistema -->
    @include('components.system-styles')
    
    @stack('styles')
    
    <style>
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-image {
            height: 200px;
            object-fit: cover;
            background-color: #f8f9fa;
        }
        .whatsapp-btn {
            background-color: #25D366;
            border-color: #25D366;
        }
        .whatsapp-btn:hover {
            background-color: #128C7E;
            border-color: #128C7E;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .search-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        .category-filter {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('catalog.index') }}">
                @if(($systemConfig['show_logo'] ?? 'true') === 'true' && !empty($systemConfig['logo']))
                    <img src="{{ asset($systemConfig['logo']) }}" 
                         alt="{{ $systemConfig['company_name'] ?? 'Logo' }}" 
                         class="catalog-logo me-2">
                @else
                    <i class="fas fa-store text-primary me-2"></i>
                @endif
                <strong>{{ $systemConfig['company_name'] ?? 'Sistema POS' }}</strong>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog.index') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-cog"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Sistema POS</h5>
                    <p class="mb-0">Catálogo de productos disponibles</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="https://wa.me/{{ config('app.whatsapp_number') }}" target="_blank" class="btn btn-success btn-sm">
                        <i class="fab fa-whatsapp"></i> Contáctanos por WhatsApp
                    </a>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col-12 text-center">
                    <small>&copy; {{ date('Y') }} Sistema POS. Todos los derechos reservados.</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>