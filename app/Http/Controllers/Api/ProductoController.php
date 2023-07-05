<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Subcategory;
use Illuminate\Http\Request;


class ProductoController extends Controller
{
    // public function index(){
    //     $objetos = Product::select('name', 'slug')->get();

    //     return response()->json($objetos);
    // }

    public function index(){
        $subcategorias=Subcategory::with('products')->get();




        return response()->json($subcategorias);
    }

    public function store(Request $request)
    {
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->contact = $request->contact;
        $order->phone = $request->phone;
        $order->status = $request->status;
        $order->envio_type = $request->envio_type;
        $order->shipping_cost = $request->shipping_cost;
        $order->total = $request->total;
        $order->content = $request->content;
        $order->envio = $request->envio;

        $order->save();
        return response()->json($order, 201);
    }

    public function search($id){
        $objeto = Product::select('id','name', 'slug')->where('id', $id)->get();

        return response()->json($objeto);
    }

}
