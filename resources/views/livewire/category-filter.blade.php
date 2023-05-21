<div>
    {{--  TARJETA --}}
    <div class="bg-white rounded-lg shadow-lg mb-6">
        <div class="px-6 py-2 flex justify-between items-center">{{-- between para colocar uno al extremo de otro --}}

            <h1 class="font-semibold text-gray-700 uppercase">{{ $category->name }}</h1>

            <div class="hidden md:block grid grid-cols-2 border border-gray-200 divide-x divide-gray-200 text-gray-500 ">
                <i class="fas fa-border-all p-3 cursor-pointer {{ $view == 'grid' ? 'text-blue-500' : '' }}"
                    wire:click="$set('view', 'grid')"></i>
                <i class="fas fa-th-list p-3 cursor-pointer {{ $view == 'list' ? 'text-blue-500' : '' }}"
                    wire:click="$set('view', 'list')"></i>
            </div>
        </div>
    </div>

    {{-- GRID DE 5 COLUMNAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 ">

        {{--  1 columna --}}
        <aside>

            <h2 class="font-semibold text-center mb-2"> Subcategorías</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($category->subcategories as $subcategory)
                    <li class="py-2 text-sm">
                        <a class="cursor-pointer hover:text-blue-500 capitalize {{ $subcategoria == $subcategory->slug ? 'text-blue-500  font-semibold' : ' ' }} "
                            {{-- Metodos magicos: cambiar el valor de alguna propiedad de componentes --}}
                            wire:click="$set('subcategoria', '{{ $subcategory->slug }}')">{{ $subcategory->name }}</a>
                    </li>
                @endforeach
            </ul>

            <h2 class="font-semibold text-center mt-4 mb-2"> Marcas</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($category->brands as $brand)
                    <li class="py-2 text-sm">
                        <a class="cursor-pointer hover:text-blue-500 capitalize {{ $marca == $brand->name ? 'text-blue-500  font-semibold' : ' ' }} "
                            {{-- Metodos magicos: cambiar el valor de alguna propiedad de componentes --}}
                            wire:click="$set('marca', '{{ $brand->name }}')">{{ $brand->name }}</a>
                    </li>
                @endforeach
            </ul>

            {{-- Botón para eliminar filtros --}}

            <x-jet-button class="mt-5" wire:click="limpiar"> {{-- Metodo limpiar --}}
                Limpiar filtros
            </x-jet-button>

        </aside>
        {{-- 4 columnas --}}
        <div class="md:col-span-2 lg:col-span-4">
            <div class="mb-4">
                {{ $products->links() }}
            </div>

            @if ($view == 'grid')
                <ul class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"> {{-- gap: cada columna tiene separación --}}
                    @forelse ($products as $product)
                        <li class="bg-white rounded-lg shadow">
                            <article>
                                <figure>
                                    <img class="h-48 w-full object-cover object-center"
                                        src="{{ Storage::url($product->images->first()->url) }}">
                                </figure>

                                <div class="py-4 px-6">
                                    <h1 class="text-lg font-semibold">
                                        <a href="{{ route('products.show', $product) }}">
                                            {{ Str::limit($product->name, 15) }}
                                        </a>
                                    </h1>
                                </div>

                                <p class="font-bold text-trueGray-700 text-center">S/{{ $product->price }}</p>

                            </article>
                        </li>
                    @empty
                        <li class="md:col-span-2 lg:col-span-4">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">Ups!</strong>
                                <span class="block sm:inline">No existen registros para ese filtro.</span>

                            </div>
                        </li>
                    @endforelse

                </ul>
            @else
                <ul>
                    @forelse($products as $product)
                        <x-products-list :product="$product" />
                    @empty
                        
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">Ups!</strong>
                                <span class="block sm:inline">No existen registros para ese filtro.</span>

                            </div>
                        
                    @endforelse
                </ul>
            @endif


            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
