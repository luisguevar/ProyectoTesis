<div class="flex item-center" x-data>
    <x-jet-secondary-button 
        disabled
        x-bind:disabled="$wire.qty <= 1" {{-- Condicion para deshabilitar disabled  --}}
        wire:loading.attr="disabled"    {{-- Condicion evitar que baje a negeativos al spamear al - --}}
        wire:target="decrement"
        wire:click="decrement">
        -
    </x-jet-secondary-button>

    <span class ="mx-2 text-gray-700">{{$qty}}</span>

    <x-jet-secondary-button 
        disabled
        x-bind:disabled="$wire.quantity == 0" {{-- Condicion para deshabilitar disabled  --}}
        wire:loading.attr="disabled"    {{-- Condicion evitar que baje a negeativos al spamear al - --}}
        wire:target="increment"     
        wire:click="increment">
        +
    </x-jet-secondary-button>
    
</div>
