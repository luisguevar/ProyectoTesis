<div x-data> {{-- Para usar alpine --}}

    <p class="text-gray-700 mb-4 "> 
        <span class="text-lg font-semibold ">Stock disponible:</span> {{$quantity}}
    </p>

    {{-- Botones de aumentar y disminuir --}}
  <div class="flex">
        <div class="mr-4">
            <x-jet-secondary-button 
            disabled
            x-bind:disabled="$wire.qty <= 1" {{-- Condicion para deshabilitar disabled  --}}
            wire:loading.attr="disabled"    {{-- Condicion evitar que baje a negeativos al spamear al - --}}
            wire:target="decrement"
            wire:click="decrement">-</x-jet-secondary-button>
            
                    <span class ="mx-2 text-gray-700">{{$qty}}</span>
            
            <x-jet-secondary-button 
            disabled
            x-bind:disabled="$wire.qty >= $wire.quantity" {{-- Condicion para deshabilitar disabled  --}}
            wire:loading.attr="disabled"    {{-- Condicion evitar que baje a negeativos al spamear al - --}}
            wire:target="increment"     
            wire:click="increment">+</x-jet-secondary-button>
        </div>

        <div class="flex-1"> {{-- Todo el ancho posible con flex-1   --}} 
            <x-jet-button 
            x-bind:disabled="$wire.qty > $wire.quantity" {{-- Condicion para deshabilitar disabled  --}}
            class="w-full justify-center" 
            wire:click="addItem" {{-- Al dar clik, llama al método --}}
            wire:loading.attr="disabled"
            wire:target="addItem" > 
                Agregar al carrito de compras
            </x-jet-button>
        </div>
  </div>
</div>
