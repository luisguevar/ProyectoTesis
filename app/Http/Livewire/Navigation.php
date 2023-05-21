<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Category;
class Navigation extends Component
{
    public function render()
    {
        //Recuperar registros
        $categories = Category::all();

        //Pasar a la vista
        return view('livewire.navigation', compact('categories'));
    }
}
