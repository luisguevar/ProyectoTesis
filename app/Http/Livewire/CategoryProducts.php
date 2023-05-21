<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CategoryProducts extends Component
{
    public $category;

    public $products=[];
    public function loadPosts(){
        $this->products=$this->category->products()->where('status', 2)->take(15)->get();
        $this->emit('glider', $this->category->id); //evento de livewire, esto lo escucha el script de glider
    }
    public function render()
    {
        return view('livewire.category-products');
    }
}
