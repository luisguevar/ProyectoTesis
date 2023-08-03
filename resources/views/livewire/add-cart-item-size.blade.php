<div x-data>



    <div>
        <p class="text-md text-gray-700 ">Seleccionar: </p>
        <select wire:model="size_id" class="form-control w-full">
            <option value="" selected disabled>Seleccione una talla</option>
            @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-2">
        {{--  <p class="text-md text-gray-700 ">Color: </p> --}}
        <select wire:model="color_id" class="form-control w-full">
            <option value="" selected disabled>Seleccione un color</option>
            @foreach ($colors as $color)
                <option value="{{ $color->id }}">{{ __($color->name) }}</option>
            @endforeach
        </select>
    </div>
    <p class="text-gray-700 my-4">
        <span class="font-semibold text-lg">Stock disponible:</span>

        @if ($quantity)
            {{ $quantity }}
        @else
            {{ $product->stock }}
        @endif

    </p>
    {{-- Botones de aumentar y disminuir --}}
    <div class="flex mt-4">
        <div class="mr-4">
            <x-jet-secondary-button disabled x-bind:disabled="$wire.qty <= 1" {{-- Condicion para deshabilitar disabled  --}}
                wire:loading.attr="disabled" {{-- Condicion evitar que baje a negeativos al spamear al - --}} wire:target="decrement" wire:click="decrement">-
            </x-jet-secondary-button>

            <span class="mx-2 text-gray-700">{{ $qty }}</span>

            <x-jet-secondary-button disabled x-bind:disabled="$wire.qty >= $wire.quantity" {{-- Condicion para deshabilitar disabled  --}}
                wire:loading.attr="disabled" {{-- Condicion evitar que baje a negeativos al spamear al - --}} wire:target="increment" wire:click="increment">+
            </x-jet-secondary-button>
        </div>

        <div class="flex-1"> {{-- Todo el ancho posible con flex-1   --}}
            <x-jet-button x-bind:disabled="!$wire.quantity" class="w-full justify-center" wire:click="addItem"
                {{-- Al dar clik, llama al método --}} wire:loading.attr="disabled" wire:target="addItem"
                style="background-color: #08769a; color: white;">
                Agregar al carrito de compras
            </x-jet-button>
        </div>
    </div>

</div>
