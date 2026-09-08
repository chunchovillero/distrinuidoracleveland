<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Calidad;
use App\Models\Proveedor;
use App\Models\ExportConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener todos los productos con sus relaciones
        $products = Product::with(['category', 'calidad', 'proveedor'])->orderBy('name')->get();
        
        // Obtener datos para los filtros
        $categories = \App\Models\Category::where('active', true)->get();
        $calidades = \App\Models\Calidad::all();
        $proveedores = \App\Models\Proveedor::where('activo', true)->get();
        
        return view('products.index', compact('products', 'categories', 'calidades', 'proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('active', true)->get();
        $calidades = \App\Models\Calidad::all();
        $proveedores = \App\Models\Proveedor::where('activo', true)->get();
        return view('products.create', compact('categories', 'calidades', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'sku' => 'nullable|unique:products',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
            'category_id' => 'required|exists:categories,id',
            'calidad_id' => 'nullable|exists:calidad,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $data = $request->all();
        $data['active'] = $request->has('active');
        
        // Mapear commission_percentage a commission
        if (isset($data['commission_percentage'])) {
            $data['commission'] = $data['commission_percentage'];
            unset($data['commission_percentage']);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('active', true)->get();
        $calidades = \App\Models\Calidad::all();
        $proveedores = \App\Models\Proveedor::where('activo', true)->get();
        return view('products.edit', compact('product', 'categories', 'calidades', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'sku' => 'nullable|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
            'category_id' => 'required|exists:categories,id',
            'calidad_id' => 'nullable|exists:calidad,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $data = $request->all();
        $data['active'] = $request->has('active');
        
        // Mapear commission_percentage a commission
        if (isset($data['commission_percentage'])) {
            $data['commission'] = $data['commission_percentage'];
            unset($data['commission_percentage']);
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Verificar si el producto tiene ventas asociadas
        $ventasAsociadas = \App\Models\SaleDetail::where('product_id', $product->id)->count();
        
        if ($ventasAsociadas > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', "No se puede eliminar el producto '{$product->name}' porque tiene {$ventasAsociadas} venta(s) asociada(s). Para mantener la integridad de los datos, desactiva el producto en su lugar.");
        }
        
        // Verificar si hay otros registros relacionados
        $relacionesExistentes = [];
        
        // Aquí podrías agregar más verificaciones según tu modelo de negocio
        // Por ejemplo: inventarios, cotizaciones, órdenes de compra, etc.
        
        if (!empty($relacionesExistentes)) {
            $mensaje = "No se puede eliminar el producto porque tiene registros relacionados: " . implode(', ', $relacionesExistentes);
            return redirect()->route('admin.products.index')->with('error', $mensaje);
        }
        
        // Si no hay relaciones críticas, proceder con la eliminación
        try {
            // Eliminar imagen si existe
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            $productName = $product->name;
            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', "Producto '{$productName}' eliminado exitosamente.");
                
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Error al eliminar el producto. Intenta desactivarlo en su lugar.');
        }
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['active' => !$product->active]);
        
        // Si es una petición AJAX, devolver JSON
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Estado del producto actualizado.',
                'active' => $product->active
            ]);
        }
        
        return redirect()->route('admin.products.index')->with('success', 'Estado del producto actualizado.');
    }

    /**
     * Search products (for AJAX)
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('active', true)
            ->where('stock', '>', 0)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    /**
     * Show export configuration modal
     */
    public function showExportConfig(Request $request)
    {
        \Log::info('showExportConfig method called', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'all_params' => $request->all()
        ]);

        try {
            $exportType = $request->get('type', 'products');
            $filters = $request->except('type');
            
            \Log::info('Processing export config', [
                'exportType' => $exportType,
                'filters' => $filters
            ]);
            
            // Configuraciones predefinidas para productos
            $defaultFields = [
                'products' => [
                    'id' => 'ID',
                    'name' => 'Nombre',
                    'sku' => 'SKU/Código',
                    'description' => 'Descripción',
                    'category' => 'Categoría',
                    'calidad' => 'Calidad',
                    'proveedor' => 'Proveedor',
                    'price' => 'Precio',
                    'stock' => 'Stock',
                    'commission' => 'Comisión (%)',
                    'active' => 'Estado'
                ]
            ];
            
            $availableFields = $defaultFields[$exportType] ?? $defaultFields['products'];
            
            // Buscar configuración guardada
            $savedConfig = null;
            try {
                $savedConfig = ExportConfiguration::getDefaultConfiguration($exportType);
            } catch (\Exception $configError) {
                \Log::warning('Error loading saved config', ['error' => $configError->getMessage()]);
            }
            
            $selectedFields = $savedConfig ? $savedConfig->selected_fields : array_keys($availableFields);
            
            $response = [
                'success' => true,
                'fields' => $availableFields,
                'selectedFields' => $selectedFields,
                'type' => $exportType,
                'filters' => $filters,
                'hasConfig' => $savedConfig !== null,
                'sortOptions' => [
                    'id' => 'ID (Orden de creación)',
                    'name' => 'Nombre (Alfabético)',
                    'sku' => 'SKU/Código',
                    'price' => 'Precio',
                    'stock' => 'Stock',
                    'category' => 'Categoría'
                ],
                'defaultSort' => 'id',
                'defaultDirection' => 'asc'
            ];
            
            \Log::info('Returning successful response', $response);
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            \Log::error('Error in showExportConfig', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export products to Excel
     */
    public function exportProducts(Request $request)
    {
        try {
            \Log::info('=== EXPORT CSV STARTING ===');
            
            // Configuración básica  
            $selectedFields = $request->get('fields', ['id', 'name', 'stock', 'price']);
            if (is_string($selectedFields)) {
                $selectedFields = explode(',', $selectedFields);
            }
            
            \Log::info('Export fields', $selectedFields);
            
            // Aplicar filtros y ordenamiento
            $query = Product::with(['category', 'calidad', 'proveedor']);
            
            // Filtros
            if ($request->filled('category_filter')) {
                $query->where('category_id', $request->get('category_filter'));
            }
            if ($request->filled('calidad_filter')) {
                $query->where('calidad_id', $request->get('calidad_filter'));
            }
            if ($request->filled('proveedor_filter')) {
                $query->where('proveedor_id', $request->get('proveedor_filter'));
            }
            if ($request->has('status_filter') && $request->get('status_filter') !== '') {
                $query->where('active', $request->get('status_filter'));
            }
            
            // Ordenamiento
            $sortBy = $request->get('sort_by', 'id');
            $sortDirection = $request->get('sort_direction', 'asc');
            
            if ($sortBy === 'category') {
                $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                      ->orderBy('categories.name', $sortDirection)
                      ->select('products.*');
            } else {
                $query->orderBy($sortBy, $sortDirection);
            }
            
            $products = $query->get();
            \Log::info('Products loaded', ['count' => $products->count()]);
            
            // Crear contenido CSV
            $csvContent = '';
            
            // Headers con codificación UTF-8 BOM para Excel
            $fieldLabels = [
                'id' => 'ID',
                'name' => 'Nombre',
                'sku' => 'SKU/Código',
                'description' => 'Descripción',
                'category' => 'Categoría',
                'calidad' => 'Calidad',
                'proveedor' => 'Proveedor',
                'price' => 'Precio',
                'stock' => 'Stock',
                'commission' => 'Comisión (%)',
                'active' => 'Estado'
            ];
            
            // Construir headers CSV
            $headers = [];
            foreach ($selectedFields as $field) {
                if (isset($fieldLabels[$field])) {
                    $headers[] = $fieldLabels[$field];
                }
            }
            $csvContent = implode(';', $headers) . "\n"; // Usar ; como separador para mejor compatibilidad
            
            // Agregar datos
            foreach ($products as $product) {
                $row = [];
                foreach ($selectedFields as $field) {
                    $value = '';
                    switch ($field) {
                        case 'id':
                            $value = $product->id;
                            break;
                        case 'name':
                            $value = $product->name ?? '';
                            break;
                        case 'sku':
                            $value = $product->sku ?? '';
                            break;
                        case 'description':
                            $value = $product->description ?? '';
                            break;
                        case 'category':
                            $value = $product->category ? $product->category->name : '';
                            break;
                        case 'calidad':
                            $value = $product->calidad ? $product->calidad->nombre : '';
                            break;
                        case 'proveedor':
                            $value = $product->proveedor ? $product->proveedor->nombre : '';
                            break;
                        case 'price':
                            $value = number_format($product->price, 2, ',', ''); // Formato español
                            break;
                        case 'stock':
                            $value = $product->stock;
                            break;
                        case 'commission':
                            $value = number_format($product->commission ?? 0, 2, ',', '');
                            break;
                        case 'active':
                            $value = $product->active ? 'Activo' : 'Inactivo';
                            break;
                    }
                    
                    // Escapar comillas y envolver en comillas si contiene separador
                    if (is_string($value) && (strpos($value, ';') !== false || strpos($value, '"') !== false || strpos($value, "\n") !== false)) {
                        $value = '"' . str_replace('"', '""', $value) . '"';
                    }
                    
                    $row[] = $value;
                }
                $csvContent .= implode(';', $row) . "\n";
            }
            
            \Log::info('CSV data prepared', ['rows' => $products->count() + 1, 'size' => strlen($csvContent)]);
            
            // Agregar BOM UTF-8 para mejor compatibilidad con Excel
            $csvContent = "\xEF\xBB\xBF" . $csvContent;
            
            // Generar archivo CSV
            $fileName = 'productos_exportados_' . date('Y-m-d') . '_' . date('H-i-s') . '.csv';
            $filePath = storage_path('app/temp/' . $fileName);
            
            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }
            
            file_put_contents($filePath, $csvContent);
            
            \Log::info('CSV file created', ['path' => $filePath, 'size' => filesize($filePath)]);
            
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Content-Transfer-Encoding' => 'binary',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'public',
                'Expires' => '0'
            ];
            
            return response()->download($filePath, $fileName, $headers)->deleteFileAfterSend(false);
            
        } catch (\Exception $e) {
            \Log::error('Error exporting products', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Error al exportar: ' . $e->getMessage());
        }
    }

    /**
     * Save export configuration
     */
    public function saveExportConfig(Request $request)
    {
        try {
            $exportType = $request->get('export_type', 'products');
            $selectedFields = $request->get('fields', []);
            
            // Eliminar configuración anterior si existe
            ExportConfiguration::where('export_type', $exportType)->delete();
            
            // Crear nueva configuración
            $config = ExportConfiguration::create([
                'export_type' => $exportType,
                'selected_fields' => $selectedFields,
                'is_default' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Configuración guardada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error saving export config', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Import products from Excel file
     */
    public function importProducts(Request $request)
    {
        try {
            \Log::info('Import request started', [
                'is_ajax' => $request->ajax(),
                'wants_json' => $request->wantsJson(),
                'has_file' => $request->hasFile('file'),
                'content_type' => $request->header('Content-Type'),
                'user_agent' => $request->header('User-Agent')
            ]);

            // Validar que se haya subido un archivo
            $request->validate([
                'file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,text/csv,text/plain,application/csv|max:10240', // Máximo 10MB
                'update_existing' => 'nullable|boolean',
                'create_missing' => 'nullable|boolean'
            ]);

            \Log::info('Starting product import', [
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_size' => $request->file('file')->getSize(),
                'update_existing' => $request->boolean('update_existing'),
                'create_missing' => $request->boolean('create_missing')
            ]);

            // Configurar límites para la importación
            ini_set('memory_limit', '1G');
            ini_set('max_execution_time', 600);

            $file = $request->file('file');
            $updateExisting = $request->boolean('update_existing', true);
            $createMissing = $request->boolean('create_missing', true);

            // Determinar el tipo de archivo y leerlo apropiadamente
            $fileExtension = strtolower($file->getClientOriginalExtension());
            \Log::info('Reading file', [
                'extension' => $fileExtension, 
                'mime_type' => $file->getMimeType(),
                'original_name' => $file->getClientOriginalName()
            ]);
            
            if ($fileExtension === 'csv') {
                // Para archivos CSV, configurar el lector específicamente
                \Log::info('Using CSV reader with semicolon delimiter');
                $reader = IOFactory::createReader('Csv');
                $reader->setDelimiter(';'); // Usar punto y coma como separador
                $reader->setEnclosure('"');
                $reader->setInputEncoding('UTF-8');
                $spreadsheet = $reader->load($file->getPathname());
            } else {
                // Para archivos Excel usar el método automático
                \Log::info('Using automatic Excel reader');
                $spreadsheet = IOFactory::load($file->getPathname());
            }
            
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();

            \Log::info('File loaded', [
                'highest_row' => $highestRow,
                'highest_column' => $highestColumn,
                'file_type' => $fileExtension
            ]);

            // Leer encabezados (primera fila)
            $headers = [];
            $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
            
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $header = $worksheet->getCell(Coordinate::stringFromColumnIndex($col) . '1')->getValue();
                if ($header) {
                    $headers[$col] = trim($header);
                }
            }

            \Log::info('Headers read', ['headers' => $headers]);

            // Mapear encabezados a campos de base de datos
            $fieldMapping = [
                'ID' => 'id',
                'Nombre' => 'name',
                'SKU/Código' => 'sku',
                'Descripción' => 'description',
                'Categoría' => 'category',
                'Calidad' => 'calidad',
                'Proveedor' => 'proveedor',
                'Precio' => 'price',
                'Stock' => 'stock',
                'Comisión (%)' => 'commission',
                'Estado' => 'active'
            ];

            // Contadores para el reporte
            $stats = [
                'processed' => 0,
                'created' => 0,
                'updated' => 0,
                'errors' => 0,
                'categories_created' => 0,
                'calidades_created' => 0,
                'proveedores_created' => 0
            ];

            $errors = [];

            // Procesar cada fila (empezar desde la fila 2, la 1 son encabezados)
            for ($row = 2; $row <= $highestRow; $row++) {
                try {
                    $stats['processed']++;
                    
                    // Leer datos de la fila
                    $rowData = [];
                    foreach ($headers as $col => $headerName) {
                        if (isset($fieldMapping[$headerName])) {
                            $cellValue = $worksheet->getCell(Coordinate::stringFromColumnIndex($col) . $row)->getValue();
                            $rowData[$fieldMapping[$headerName]] = $cellValue;
                        }
                    }

                    // Validar datos obligatorios
                    if (empty($rowData['name'])) {
                        $errors[] = "Fila $row: El nombre del producto es obligatorio";
                        $stats['errors']++;
                        continue;
                    }

                    // Procesar categoría, calidad y proveedor
                    $categoryId = $this->processCategory($rowData['category'] ?? null, $createMissing, $stats);
                    $calidadId = $this->processCalidad($rowData['calidad'] ?? null, $createMissing, $stats);
                    $proveedorId = $this->processProveedor($rowData['proveedor'] ?? null, $createMissing, $stats);

                    // Preparar datos del producto
                    $productData = [
                        'name' => $rowData['name'],
                        'sku' => $rowData['sku'] ?? null,
                        'description' => $rowData['description'] ?? null,
                        'category_id' => $categoryId,
                        'calidad_id' => $calidadId,
                        'proveedor_id' => $proveedorId,
                        'price' => $this->parsePrice($rowData['price'] ?? 0),
                        'stock' => intval($rowData['stock'] ?? 0),
                        'commission' => $this->parseCommission($rowData['commission'] ?? 0),
                        'active' => $this->parseActive($rowData['active'] ?? 'Activo')
                    ];

                    // Buscar producto existente por ID o SKU
                    $existingProduct = null;
                    if (!empty($rowData['id'])) {
                        $existingProduct = Product::find($rowData['id']);
                    } elseif (!empty($rowData['sku'])) {
                        $existingProduct = Product::where('sku', $rowData['sku'])->first();
                    }

                    if ($existingProduct && $updateExisting) {
                        // Actualizar producto existente
                        $oldStock = $existingProduct->stock;
                        $existingProduct->update($productData);
                        $stats['updated']++;
                        \Log::info("Product updated", [
                            'id' => $existingProduct->id, 
                            'name' => $productData['name'],
                            'old_stock' => $oldStock,
                            'new_stock' => $productData['stock'],
                            'stock_changed' => $oldStock != $productData['stock']
                        ]);
                    } elseif (!$existingProduct) {
                        // Crear nuevo producto
                        $newProduct = Product::create($productData);
                        $stats['created']++;
                        \Log::info("Product created", ['id' => $newProduct->id, 'name' => $productData['name']]);
                    }

                } catch (\Exception $e) {
                    $errors[] = "Fila $row: " . $e->getMessage();
                    $stats['errors']++;
                    \Log::error("Error processing row $row", ['error' => $e->getMessage(), 'row_data' => $rowData ?? null]);
                }
            }

            \Log::info('Import completed', ['stats' => $stats]);

            // Preparar mensaje de resultado
            $message = "Importación completada. ";
            $message .= "Procesadas: {$stats['processed']}, ";
            $message .= "Creadas: {$stats['created']}, ";
            $message .= "Actualizadas: {$stats['updated']}, ";
            $message .= "Errores: {$stats['errors']}";

            if ($stats['categories_created'] > 0 || $stats['calidades_created'] > 0 || $stats['proveedores_created'] > 0) {
                $message .= ". Creados automáticamente: ";
                if ($stats['categories_created'] > 0) $message .= "Categorías: {$stats['categories_created']} ";
                if ($stats['calidades_created'] > 0) $message .= "Calidades: {$stats['calidades_created']} ";
                if ($stats['proveedores_created'] > 0) $message .= "Proveedores: {$stats['proveedores_created']} ";
            }

            if (!empty($errors)) {
                $message .= "\n\nErrores encontrados:\n" . implode("\n", array_slice($errors, 0, 10));
                if (count($errors) > 10) {
                    $message .= "\n... y " . (count($errors) - 10) . " errores más.";
                }
            }

            // Responder según el tipo de petición
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'stats' => $stats,
                    'errors' => $errors
                ]);
            }

            return redirect()->route('admin.products.index')->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Error importing products', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // Responder según el tipo de petición
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al importar productos: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error al importar productos: ' . $e->getMessage());
        }
    }

    /**
     * Process category - find existing or create new
     */
    private function processCategory($categoryName, $createMissing, &$stats)
    {
        if (empty($categoryName) || $categoryName === 'Sin categoría') {
            return null;
        }

        $category = Category::where('name', trim($categoryName))->first();
        
        if (!$category && $createMissing) {
            $category = Category::create(['name' => trim($categoryName)]);
            $stats['categories_created']++;
            \Log::info("Category created", ['name' => $categoryName]);
        }

        return $category ? $category->id : null;
    }

    /**
     * Process calidad - find existing or create new
     */
    private function processCalidad($calidadName, $createMissing, &$stats)
    {
        if (empty($calidadName) || $calidadName === 'Sin calidad') {
            return null;
        }

        $calidad = Calidad::where('nombre', trim($calidadName))->first();
        
        if (!$calidad && $createMissing) {
            $calidad = Calidad::create(['nombre' => trim($calidadName)]);
            $stats['calidades_created']++;
            \Log::info("Calidad created", ['nombre' => $calidadName]);
        }

        return $calidad ? $calidad->id : null;
    }

    /**
     * Process proveedor - find existing or create new
     */
    private function processProveedor($proveedorName, $createMissing, &$stats)
    {
        if (empty($proveedorName) || $proveedorName === 'Sin proveedor') {
            return null;
        }

        $proveedor = Proveedor::where('nombre', trim($proveedorName))->first();
        
        if (!$proveedor && $createMissing) {
            $proveedor = Proveedor::create(['nombre' => trim($proveedorName)]);
            $stats['proveedores_created']++;
            \Log::info("Proveedor created", ['nombre' => $proveedorName]);
        }

        return $proveedor ? $proveedor->id : null;
    }

    /**
     * Parse price value
     */
    private function parsePrice($price)
    {
        if (is_string($price)) {
            // Remover símbolos de moneda y espacios
            $price = preg_replace('/[^\d,.]/', '', $price);
            $price = str_replace(',', '', $price);
        }
        return floatval($price);
    }

    /**
     * Parse commission value
     */
    private function parseCommission($commission)
    {
        if (is_string($commission)) {
            // Remover el símbolo % y espacios
            $commission = preg_replace('/[^\d,.]/', '', $commission);
            $commission = str_replace(',', '.', $commission);
        }
        return floatval($commission);
    }

    /**
     * Parse active status
     */
    private function parseActive($active)
    {
        if (is_string($active)) {
            return strtolower(trim($active)) === 'activo';
        }
        return (bool) $active;
    }

    /**
     * Clean value for Excel compatibility
     */
    private function cleanExcelValue($value)
    {
        if ($value === null) {
            return '';
        }
        
        // Convertir a string y limpiar caracteres problemáticos
        $cleaned = (string) $value;
        
        // Remover caracteres de control que pueden causar problemas
        $cleaned = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $cleaned);
        
        // Limitar longitud para evitar problemas
        if (strlen($cleaned) > 32767) {
            $cleaned = substr($cleaned, 0, 32767);
        }
        
        return trim($cleaned);
    }

    /**
     * Excel nativo - método más directo
     */
    public function exportProductsNative(Request $request)
    {
        try {
            \Log::info('=== NATIVE EXCEL EXPORT STARTING ===');
            
            // Obtener campos
            $selectedFields = $request->get('fields', ['id', 'name', 'stock', 'price']);
            if (is_string($selectedFields)) {
                $selectedFields = explode(',', $selectedFields);
            }
            
            // Crear spreadsheet directamente
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Productos');
            
            // Headers simples
            $fieldLabels = [
                'id' => 'ID',
                'name' => 'Nombre',
                'sku' => 'SKU',
                'description' => 'Descripción',
                'category' => 'Categoría',
                'calidad' => 'Calidad',
                'proveedor' => 'Proveedor',
                'price' => 'Precio',
                'stock' => 'Stock',
                'commission' => 'Comisión',
                'active' => 'Estado'
            ];
            
            // Escribir headers
            $col = 1;
            foreach ($selectedFields as $field) {
                if (isset($fieldLabels[$field])) {
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($col) . '1', $fieldLabels[$field]);
                    $col++;
                }
            }
            
            // Obtener datos
            $products = Product::with(['category', 'calidad', 'proveedor'])->orderBy('id')->get();
            
            // Escribir datos
            $row = 2;
            foreach ($products as $product) {
                $col = 1;
                foreach ($selectedFields as $field) {
                    $value = '';
                    switch ($field) {
                        case 'id':
                            $value = $product->id;
                            break;
                        case 'name':
                            $value = $product->name ?? '';
                            break;
                        case 'sku':
                            $value = $product->sku ?? '';
                            break;
                        case 'description':
                            $value = $product->description ?? '';
                            break;
                        case 'category':
                            $value = $product->category ? $product->category->name : '';
                            break;
                        case 'calidad':
                            $value = $product->calidad ? $product->calidad->nombre : '';
                            break;
                        case 'proveedor':
                            $value = $product->proveedor ? $product->proveedor->nombre : '';
                            break;
                        case 'price':
                            $value = floatval($product->price);
                            break;
                        case 'stock':
                            $value = intval($product->stock);
                            break;
                        case 'commission':
                            $value = floatval($product->commission ?? 0);
                            break;
                        case 'active':
                            $value = $product->active ? 'Activo' : 'Inactivo';
                            break;
                    }
                    
                    $sheet->setCellValue(Coordinate::stringFromColumnIndex($col) . $row, $value);
                    $col++;
                }
                $row++;
            }
            
            // Guardar como Excel
            $fileName = 'productos_native_' . date('Y-m-d_H-i-s') . '.xlsx';
            $filePath = storage_path('app/temp/' . $fileName);
            
            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }
            
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);
            
            \Log::info('Native Excel created', ['path' => $filePath, 'size' => filesize($filePath)]);
            
            // Response directo
            return response()->file($filePath, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Native export error', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Simple Excel export - método alternativo
     */
    public function exportProductsSimple(Request $request)
    {
        try {
            \Log::info('Starting simple product export');
            
            // Configurar memoria
            ini_set('memory_limit', '512M');
            ini_set('max_execution_time', 300);
            
            // Obtener campos seleccionados
            $selectedFields = $request->get('fields', ['id', 'name', 'stock', 'price']);
            if (is_string($selectedFields)) {
                $selectedFields = explode(',', $selectedFields);
            }
            
            // Aplicar ordenamiento
            $sortBy = $request->get('sort_by', 'id');
            $sortDirection = $request->get('sort_direction', 'asc');
            
            // Obtener productos
            $query = Product::with(['category', 'calidad', 'proveedor']);
            
            if ($sortBy === 'category') {
                $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                      ->orderBy('categories.name', $sortDirection)
                      ->select('products.*');
            } else {
                $query->orderBy($sortBy, $sortDirection);
            }
            
            $products = $query->get();
            
            \Log::info('Products loaded', ['count' => $products->count()]);
            
            // Crear Excel usando método simple
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Productos');
            
            // Mapeo de campos
            $fieldLabels = [
                'id' => 'ID',
                'name' => 'Nombre',
                'sku' => 'SKU',
                'description' => 'Descripción',
                'category' => 'Categoría',
                'calidad' => 'Calidad',
                'proveedor' => 'Proveedor',
                'price' => 'Precio',
                'stock' => 'Stock',
                'commission' => 'Comisión',
                'active' => 'Estado'
            ];
            
            // Escribir encabezados
            $col = 1;
            foreach ($selectedFields as $field) {
                if (isset($fieldLabels[$field])) {
                    $sheet->setCellValueByColumnAndRow($col, 1, $fieldLabels[$field]);
                    $col++;
                }
            }
            
            // Escribir datos
            $row = 2;
            foreach ($products as $product) {
                $col = 1;
                foreach ($selectedFields as $field) {
                    $value = '';
                    switch ($field) {
                        case 'id':
                            $value = $product->id;
                            break;
                        case 'name':
                            $value = $product->name ?? '';
                            break;
                        case 'sku':
                            $value = $product->sku ?? '';
                            break;
                        case 'description':
                            $value = $product->description ?? '';
                            break;
                        case 'category':
                            $value = $product->category ? $product->category->name : '';
                            break;
                        case 'calidad':
                            $value = $product->calidad ? $product->calidad->nombre : '';
                            break;
                        case 'proveedor':
                            $value = $product->proveedor ? $product->proveedor->nombre : '';
                            break;
                        case 'price':
                            $value = $product->price;
                            break;
                        case 'stock':
                            $value = $product->stock;
                            break;
                        case 'commission':
                            $value = $product->commission ?? 0;
                            break;
                        case 'active':
                            $value = $product->active ? 'Activo' : 'Inactivo';
                            break;
                    }
                    
                    $sheet->setCellValueByColumnAndRow($col, $row, $value);
                    $col++;
                }
                $row++;
            }
            
            \Log::info('Excel data written', ['rows' => $row - 1]);
            
            // Crear archivo
            $fileName = 'productos_simple_' . date('Y-m-d_H-i-s') . '.xlsx';
            $filePath = storage_path('app/temp/' . $fileName);
            
            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }
            
            // Crear writer básico
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);
            
            \Log::info('File saved', ['path' => $filePath, 'size' => filesize($filePath)]);
            
            // Headers simples
            $headers = [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
            ];
            
            return response()->download($filePath, $fileName, $headers)->deleteFileAfterSend(false);
            
        } catch (\Exception $e) {
            \Log::error('Simple export error', [
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            
            return response()->json(['error' => 'Error al exportar: ' . $e->getMessage()], 500);
        }
    }
}
