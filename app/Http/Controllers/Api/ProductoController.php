<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductoController extends Controller
{
    public function index(){
        $objetos = Product::select('name', 'slug')->get();

        return response()->json($objetos);
    }

    public function search($id){
        $objetos = Product::select('id','name', 'slug')->where('id', $id)->get();

        return response()->json($objetos);
    }
    
}
