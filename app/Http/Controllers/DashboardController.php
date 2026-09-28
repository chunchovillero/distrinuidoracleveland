<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $metrics = [
            'totalSales' => Sale::where('status', 'completed')->count(),
            'salesToday' => Sale::whereDate('sale_date', today())->where('status', 'completed')->count(),
            'totalProducts' => Product::where('active', true)->count(),
            'lowStockProducts' => Product::whereColumn('stock', '<=', 'min_stock')->where('active', true)->count(),
            'salesAmount' => Sale::where('status', 'completed')->sum('total'),
        ];
        return view('admin.dashboard', compact('metrics'));
    }
}