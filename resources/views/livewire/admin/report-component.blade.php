<div class="conteiner py-12">


    <x-jet-action-section>
        <x-slot name="title">
            Reportes de Pedidos
        </x-slot>
        <x-slot name="description">
            Genere un pdf con el listado de todos los pedidos segun un filtro determinado
        </x-slot>
        <x-slot name="content">



            <div class="mb-4" style="display: flex; justify-content: space-between">
                <div>
                    <x-jet-label value="Tipo de Reporte"></x-jet-label>
                    <select name="" id="" class="w-full form-control">
                        <option value="" selected disabled>Seleccione un tipo de reporte</option>
                        <option value="1">Productos más vendidos</option>
                    </select>
                </div>
                <div style="align-self: flex-end;">
                    <x-jet-button>
                        Listar
                    </x-jet-button>

                    <x-button-enlace style="margin: 5px" wire:click="generarPDF">
                        Generar PDF
                    </x-button-enlace>
                </div>
            </div>




            <x-table-responsive>

                {{-- <div class="px-6 py-4">
						<x-jet-input wire:model="search" class="w-full h-10 p-4" tipe="text"
							placeholder="Ingrese el nombre del producto que quiere buscar" />
					</div> --}}


                <table class="min-w-full divide-y divide-gray-200">
                    <thead>

                        <tr>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Producto
                            </th>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Subcategoría
                            </th>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Categoría
                            </th>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Cantidad vendida
                            </th>


                            <th class="px-6 py-3 bg-gray-50"></th>
                        </tr>

                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">


                        @if (!empty($topProducts))

                            <ul>
                                @foreach ($topProducts as $productId => $productData)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-gray-900">
                                                {{ $productData['name'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm text-gray-900">
                                                {{ $productData['subcategory'] }}
                                            </div>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $productData['category'] }}
                                            </div>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="text-sm text-gray-900">
                                                {{ $productData['quantity'] }}

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </ul>
                        @else
                            <p>No hay productos vendidos.</p>
                        @endif
                    </tbody>
                </table>
            </x-table-responsive>
        </x-slot>
    </x-jet-action-section>







</div>
