<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    //
    public function index() {
        $products = Product::with('category', 'brand', 'productImage')->limit(8)->get(); 
        return Inertia::render('Admin/Dashboard',[
            'products' => $products,
            'canLogin' => app('router')->has('login'),
            'canRegister' => app('router')->has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    
}
