<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Color;

class UpdateCartItemColor extends Component
{
    public $rowId, $qty, $quantity;

    public function mount(){
        
    }

    public  function decrement(){
        $this->qty = $this->qty - 1;
        Cart::update($this->rowId, $this->qty);
        $this->emit('render');
    }
    public function increment(){
        $this->qty = $this->qty + 1;
        Cart::update($this->rowId, $this->qty);
        $this->emit('render');
    }

    
    public function render()
    {
        $item = Cart::get($this->rowId);
        $this->qty = $item->qty;
        $color = Color::where('name', $item->options->color)->first();
        $this->quantity = qty_available($item->id, $color->id);
        return view('livewire.update-cart-item-color');
    }
}
