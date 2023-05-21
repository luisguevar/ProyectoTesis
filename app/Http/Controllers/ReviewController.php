<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
    
        $request->validate([
            'comment' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $product->reviews()->create([
            'comment' => $request->comment,
            'rating' => $request->rating,
            'user_id' => auth()->id()
        ]);

        session()->flash('flash.banner', 'Reseña agregada con exito');
        session()->flash('flash.bannerStyle', 'success');
        
        return redirect()->back();
        /* return $request->all(); */
    }
}
