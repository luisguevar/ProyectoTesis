<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lista de Productos
            </h2>
    
            <x-button-enlace 
                class="ml-auto" 
                href="{{route('admin.products.create')}}">
                Agregar Producto
            </x-button-enlace>
        </div>
    </x-slot>

    <div class="conteiner py-12">
        <x-table-responsive>

            <div class="px-6 py-4">
                <x-jet-input 
                wire:model="search" 
                class="w-full h-10 p-4" 
                tipe="text"
                placeholder="Ingrese el nombre del producto que quiere buscar" />
            </div>

            @if ($products->count()) {{-- Si existen registros --}}
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>

                        <tr>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Nombre
                            </th>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Categoria
                            </th>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Estado
                            </th>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Precio
                            </th>
                            

                            <th class="px-6 py-3 bg-gray-50"></th>
                        </tr>

                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($products as $product)
                            <tr v-for="(person, i) in persons" :key="i">

                                {{-- Nombre --}}
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <div class="flex items-center">

                                        {{-- Imagen del producto --}}
                                        <div class="flex-shrink-0 w-10 h-10">
                                            @if ($product->images->count())
                                                <img class="w-10 h-10 rounded-full object-cover"
                                                 src="{{ Storage::url($product->images->first()->url) }}" alt="person.name">
                                            
                                            @else
                                            <img class="w-10 h-10 rounded-full object-cover"
                                                 src="https://images.pexels.com/photos/2008265/pexels-photo-2008265.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="person.name">
                                            
                                            @endif

                                        </div>

                                        {{-- Nombre del producto --}}
                                        <div class="ml-4">
                                            <div class="text-sm font-medium leading-5 text-gray-900">
                                                {{ $product->name }}
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                {{-- Categoria --}}
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <div class="text-sm leading-5 text-gray-900">
                                        {{ $product->subcategory->category->name }}
                                    </div>
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    @switch($product->status)
                                        @case(1)
                                            <span
                                                class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                                Borrador
                                            </span>
                                        @break

                                        @case(2)
                                            <span
                                                class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                Publicado
                                            </span>
                                        @break

                                        @default
                                    @endswitch
                                </td>

                            

                                {{-- Precio --}}
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <div class="text-sm leading-5 text-gray-900">
                                    S/ {{ $product->price}}
                                    </div>
                                </td>

                                {{-- enlace editar --}}   
                                </td>
                                <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap">
                                    <a href="{{route('admin.products.edit', $product)}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>

                                
                            </tr>
                        @endforeach
                        <!-- More rows... -->
                    </tbody>
                </table> 
            @else
                <div class="px-6 py-4">
                    No se encontraron registros
                </div>  
            @endif



            @if ($products->hasPages()) {{-- Si existen datos de paginación --}}
                <div class="px-6 py-4">
                    {{ $products->links() }}
                </div>  
            @endif

        </x-table-responsive>
    </div>
</div>
