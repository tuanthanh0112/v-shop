<?php

namespace App\Http\Repositories;


use App\Models\Product;


class CartRepository {

    public function searchProduct($searchProducts,$searchBrand,$searchCategory)
    {
        
        $productsSearch = Product::with('category','brand', 'productImage')->Where('title','LIKE', "%{$searchProducts}%")
        ->orWhereHas('brand',function($q) use ($searchBrand){return $q->where('name', 'LIKE', "%{$searchBrand}%");})
        ->orWhereHas('category', function($q) use ($searchCategory){return $q->where('name', 'LIKE', "%{$searchCategory}%");})->get();
        return $productsSearch;
    }
}