<div class="flex-1 relative" x-data>
    <form action="{{ route('search') }}" autocomplete="off">
        <x-jet-input name="name" wire:model="search" type="text" class="w-full"
            placeholder="¿Estás buscando algún producto?" />

        <button class="absolute top-0 right-0 w-12 h-full text-withe flex items-center justify-center rounded-r-md"
            style="background-color:#17a2b8">
            <i class="fa fa-search" style="color: white"></i>
        </button>
    </form>

    <div class="absolute w-full shadow mt-1 hidden":class="{ 'hidden' : !$wire.open } "
        @click.away="$wire.open = false">
        {{-- Abslute para que aparezca encima de todo, necesita el relative --}}
        <div class="bg-white rounded-lg ">
            <div class="px-4 py-3 space-y-1">
                @forelse ($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="flex">
                        <img class="w-8 h-12 object-cover" src="{{ Storage::url($product->images->first()->url) }}"
                            alt="">
                        <div class="ml-4 text-gray-700">
                            <p class="text-lg font-semibold leading-5">{{ $product->name }}</p>
                            <p>Categoria: {{ $product->subcategory->category->name }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-lg leading-5">No se encontraron productos</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
