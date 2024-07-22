<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    
    public function index() 
    {
        $products = Product::with('category', 'brand', 'productImage')->limit(8)->get(); 

        return Inertia::render('User/Index', [
            'products' => $products,
            'canLogin' => app('router')->has('login'),
            'canRegister' => app('router')->has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

   

    
}