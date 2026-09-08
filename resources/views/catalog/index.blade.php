@extends('layouts.catalog')

@section('title', 'Catálogo de Productos')

@section('content')
    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="text-center mb-4">
                        <i class="fas fa-shopping-bag me-3"></i>
                        Catálogo de Productos
                    </h1>
                    <p class="text-center lead mb-5">Encuentra los mejores productos al mejor precio</p>
                    
                    <form method="GET" action="{{ route('catalog.index') }}">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Buscar productos...">
                            <button class="btn btn-light" type="submit">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Filter -->
    @if($categories->count() > 0)
        <section class="category-filter">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            <a href="{{ route('catalog.index', ['search' => request('search')]) }}" 
                               class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                <i class="fas fa-th-large"></i> Todas las Categorías
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('catalog.index', ['category' => $category->id, 'search' => request('search')]) }}" 
                                   class="btn {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Products Grid -->
    <section class="py-5">
        <div class="container">
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card product-card h-100 shadow-sm">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" 
                                         class="card-img-top product-image" 
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="card-img-top product-image d-flex align-items-center justify-content-center bg-light">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ $product->name }}</h6>
                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>
                                    <div class="mb-2">
                                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                        @if($product->stock <= 5)
                                            <span class="badge bg-warning">Últimas unidades</span>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="text-primary mb-0">
                                            ${{ number_format($product->price, 0, ',', '.') }}
                                        </h5>
                                        <small class="text-muted">Stock: {{ $product->stock }}</small>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('catalog.show', $product) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> Ver Detalles
                                        </a>
                                        <a href="{{ route('catalog.whatsapp', $product) }}" 
                                           target="_blank" 
                                           class="btn btn-success whatsapp-btn btn-sm">
                                            <i class="fab fa-whatsapp"></i> Cotizar por WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-4x text-muted mb-4"></i>
                            <h3 class="text-muted">No se encontraron productos</h3>
                            <p class="text-muted">
                                @if(request('search') || request('category'))
                                    Intenta cambiar los filtros de búsqueda
                                @else
                                    No hay productos disponibles en este momento
                                @endif
                            </p>
                            @if(request('search') || request('category'))
                                <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Ver todos los productos
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Lazy loading para imágenes
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
</script>
@endpush