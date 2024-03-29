<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        /* Condicion para mostrar si tienes ordenes pendientes */
        if (auth()->user()) {
            $pendiente = Order::where('status', 1)->where('user_id', auth()->user()->id)->count();
            if ($pendiente) {
                $mensaje = "Tienes $pendiente ordenes pendientes. <a class='font-bold' href='" . route('orders.index') . "?status=1'> Ir a pagar </a> ";
                session()->flash('flash.banner', $mensaje);
                /* session()->flash('flash.bannerStyle', 'blue'); Mensaje rojo*/
            }
        }


        $categories = Category::all();
        $allData = $this->CategoriaProductos();
        return view('welcome', compact('categories', 'allData'));
    }

    public function CategoriaProductos()
    {
        $categorias = Category::with('products.images')->get();

        $allData = [
            'categorias' => $categorias,
        ];

        // Si deseas, puedes agregar más datos a la variable $allData aquí

        return $allData;
    }
}
