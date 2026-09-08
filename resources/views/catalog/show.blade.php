<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Catálogo de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .product-image {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            max-height: 400px;
            object-fit: cover;
            width: 100%;
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .product-info {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            height: 100%;
        }

        .price-display {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--success-color);
            margin: 1rem 0;
        }

        .stock-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
        }

        .whatsapp-btn {
            background: linear-gradient(135deg, #25d366, #128c7e);
            border: none;
            color: white;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.6);
            color: white;
        }

        .back-btn {
            background: var(--secondary-color);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: #5a6268;
            color: white;
            transform: translateY(-1px);
        }

        .category-badge {
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .category-badge:hover {
            color: white;
            opacity: 0.9;
        }

        .info-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary-color);
        }

        .related-products {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .related-product-card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .related-product-card:hover {
            transform: translateY(-5px);
        }

        .related-product-img {
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .breadcrumb {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .price-display {
                font-size: 2rem;
            }
            
            .product-info {
                padding: 1.5rem;
            }
            
            .whatsapp-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('catalog.index') }}">
                <i class="fas fa-store"></i> Catálogo de Productos
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
                            <i class="fas fa-cog"></i> Administración
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Breadcrumb -->
        <nav class="breadcrumb fade-in">
            <a class="breadcrumb-item text-decoration-none" href="{{ route('catalog.index') }}">Inicio</a>
            <a class="breadcrumb-item text-decoration-none" href="{{ route('catalog.index') }}?category={{ $product->category->id }}">{{ $product->category->name }}</a>
            <span class="breadcrumb-item active">{{ $product->name }}</span>
        </nav>

        <div class="row fade-in">
            <!-- Imagen del producto -->
            <div class="col-lg-6 mb-4">
                <div class="text-center">
                    @if($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="product-image">
                    @else
                        <div class="d-flex align-items-center justify-content-center product-image bg-light">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del producto -->
            <div class="col-lg-6">
                <div class="product-info">
                    <div class="mb-3">
                        <a href="{{ route('catalog.index') }}?category={{ $product->category->id }}" class="category-badge">
                            <i class="fas fa-tag"></i> {{ $product->category->name }}
                        </a>
                    </div>

                    <h1 class="display-6 mb-3">{{ $product->name }}</h1>

                    @if($product->sku)
                        <p class="text-muted mb-3">
                            <strong>SKU:</strong> {{ $product->sku }}
                        </p>
                    @endif

                    <div class="price-display">
                        ${{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <!-- Stock disponible -->
                    <div class="mb-4">
                        @if($product->stock > 10)
                            <span class="badge stock-badge bg-success">
                                <i class="fas fa-check-circle"></i> En stock ({{ $product->stock }} disponibles)
                            </span>
                        @elseif($product->stock > 0)
                            <span class="badge stock-badge bg-warning">
                                <i class="fas fa-exclamation-triangle"></i> Pocas unidades ({{ $product->stock }} disponibles)
                            </span>
                        @else
                            <span class="badge stock-badge bg-danger">
                                <i class="fas fa-times-circle"></i> Sin stock
                            </span>
                        @endif
                    </div>

                    @if($product->description)
                        <div class="mb-4">
                            <h5>Descripción</h5>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Botones de acción -->
                    <div class="d-grid gap-2 d-md-flex">
                        @if($product->stock > 0)
                            <a href="{{ route('catalog.whatsapp', $product) }}" 
                               class="whatsapp-btn me-md-2" 
                               target="_blank">
                                <i class="fab fa-whatsapp me-2"></i> Cotizar por WhatsApp
                            </a>
                        @else
                            <button class="whatsapp-btn me-md-2" disabled>
                                <i class="fas fa-times me-2"></i> Producto no disponible
                            </button>
                        @endif
                        
                        <a href="{{ route('catalog.index') }}" class="back-btn">
                            <i class="fas fa-arrow-left me-2"></i> Volver al catálogo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="row mt-5 fade-in">
            <div class="col-md-4">
                <div class="info-card">
                    <h6><i class="fas fa-truck text-primary me-2"></i>Disponibilidad</h6>
                    <p class="mb-0 text-muted">Consulta disponibilidad y tiempos de entrega por WhatsApp</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <h6><i class="fas fa-credit-card text-primary me-2"></i>Métodos de Pago</h6>
                    <p class="mb-0 text-muted">Efectivo, tarjetas, transferencias y más opciones disponibles</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <h6><i class="fas fa-headset text-primary me-2"></i>Atención al Cliente</h6>
                    <p class="mb-0 text-muted">Soporte personalizado para resolver todas tus dudas</p>
                </div>
            </div>
        </div>

        <!-- Productos relacionados -->
        @if($relatedProducts->count() > 0)
            <div class="row mt-5 fade-in">
                <div class="col-12">
                    <div class="related-products">
                        <h4 class="mb-4">
                            <i class="fas fa-star text-warning me-2"></i>Productos Relacionados
                        </h4>
                        <div class="row">
                            @foreach($relatedProducts as $relatedProduct)
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card related-product-card h-100">
                                        @if($relatedProduct->image)
                                            <img src="{{ asset('images/products/' . $relatedProduct->image) }}" 
                                                 class="card-img-top related-product-img" 
                                                 alt="{{ $relatedProduct->name }}">
                                        @else
                                            <div class="related-product-img bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                                            <p class="card-text text-muted small flex-grow-1">
                                                {{ Str::limit($relatedProduct->description, 80) }}
                                            </p>
                                            <div class="mt-auto">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="h6 text-success mb-0">
                                                        ${{ number_format($relatedProduct->price, 0, ',', '.') }}
                                                    </span>
                                                    <a href="{{ route('catalog.show', $relatedProduct) }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        Ver detalles
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-store me-2"></i>Catálogo de Productos</h6>
                    <p class="text-muted">Encuentra los mejores productos con la mejor atención al cliente.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6>Contacto</h6>
                    <p class="text-muted">
                        <i class="fab fa-whatsapp me-2"></i>Cotiza por WhatsApp<br>
                        <i class="fas fa-clock me-2"></i>Atención: Lunes a Sábado
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    </script>
</body>
</html>