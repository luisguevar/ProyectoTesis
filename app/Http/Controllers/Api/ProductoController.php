<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{


    public function CategoriaProductos()
    {
        $categorias = Category::with('products.images')->get();

        $categorias->transform(function ($categoria) {
            $categoria->products->transform(function ($producto) {
                $producto->first_image_url = null;
                if ($producto->images->isNotEmpty()) {
                    $firstImage = $producto->images->first();
                    $producto->first_image_url = $this->generateImageUrl($firstImage->url);
                }
                return $producto;
            });

            return $categoria;
        });

        return response()->json($categorias);
    }

    private function generateImageUrl($url)
    {
        $host = 'http://127.0.0.1:8000';
        return $host . Storage::url($url);
    }



    public function index()
    {
        $subcategorias = Subcategory::with('products')->get();

        return response()->json($subcategorias);
    }


    public function search($id)
    {
        $objetos = Product::select('id', 'name', 'slug')->where('id', $id)->get();

        return response()->json($objetos);
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
}
