<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AddCartItemColor extends Component
{
    public $product, $colors;
    public $color_id = ""; //Aqui sabre que color selecciona
    public $qty = 1;
    public $quantity = 0; //Dejar en cero hasta escoger un color

    public $options = [
        'size_id' => null
    ];

    public function mount()
    {
        $this->colors = $this->product->colors;
        $this->options['image'] = Storage::url($this->product->images->first()->url);
    }

    //Se activa al seleccionar un color
    public function updatedColorId($value)
    {
        $color = $this->product->colors->find($value);
        $this->quantity = qty_available($this->product->id,$color->id);
        $this->options['color'] = $color->name;
        $this->options['color_id'] = $color->id;
    }

    public  function decrement()
    {
        $this->qty = $this->qty - 1;
    }
    public function increment()
    {
        $this->qty = $this->qty + 1;
    }
    public function addItem()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'weight' => '550',
            'options' => $this->options, //imagen del producto
        ]);
        $this->quantity = qty_available($this->product->id, $this->color_id);
        $this->reset('qty');
        $this->emitTo('dropdow-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item-color');
    }
}
