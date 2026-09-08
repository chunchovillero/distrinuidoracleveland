<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Mostrar el catálogo público de productos
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('category');
        $search = $request->get('search');

        $query = Product::where('active', true)
                       ->where('show_in_catalog', true)
                       ->where('stock', '>', 0)
                       ->with('category');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $products = $query->orderBy('name')->paginate(12);
        
        $categories = Category::where('active', true)
                             ->whereHas('products', function($q) {
                                 $q->where('active', true)
                                   ->where('show_in_catalog', true)
                                   ->where('stock', '>', 0);
                             })
                             ->get();

        return view('catalog.index', compact('products', 'categories', 'categoryId', 'search'));
    }

    /**
     * Mostrar detalles de un producto en el catálogo
     */
    public function show(Product $product)
    {
        if (!$product->active || !$product->show_in_catalog || $product->stock <= 0) {
            abort(404);
        }

        $relatedProducts = Product::forCatalog()
                                 ->where('category_id', $product->category_id)
                                 ->where('id', '!=', $product->id)
                                 ->limit(4)
                                 ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Generar mensaje de WhatsApp para cotización
     */
    public function generateWhatsAppMessage(Product $product)
    {
        $message = "Hola! Me interesa el producto: *{$product->name}*\n\n";
        $message .= "Precio: $" . number_format($product->price, 0, ',', '.') . "\n";
        $message .= "¿Podrías darme más información?\n\n";
        $message .= "Gracias!";

        // Número de WhatsApp de la empresa (configurable)
        $whatsappNumber = config('app.whatsapp_number', '573001234567');
        
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);

        return redirect($whatsappUrl);
    }

    /**
     * API para búsqueda en tiempo real
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::forCatalog()
                          ->where(function($q) use ($query) {
                              $q->where('name', 'LIKE', "%{$query}%")
                                ->orWhere('description', 'LIKE', "%{$query}%");
                          })
                          ->limit(5)
                          ->get(['id', 'name', 'price', 'image']);

        return response()->json($products);
    }
}
