<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Subcategory;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // Acceder a la subcategoría del producto
        $subcategoryName = $product->subcategory->name; // Suponiendo que el campo de nombre de la subcategoría es "name"

        return view('products.show', compact('product', 'subcategoryName'));
    }
}
