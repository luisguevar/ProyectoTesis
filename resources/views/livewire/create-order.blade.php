<div class="conteiner py-8 grid lg:grid-cols-2 xl:grid-cols-5 gap-6">
    <div class="order-2 lg:order-1 lg:col-span-1 xl:col-span-3">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-4">
                <x-jet-label value="Nombre de contacto" />
                <x-jet-input type="text" wire:model.defer="contact"
                    placeholder="Nombre de la persona que recibe el producto" class="w-full" />
                <x-jet-input-error for="contact" />
            </div>

            <div>
                <x-jet-label value="Teléfono de contacto" />
                <x-jet-input type="text" wire:model.defer="phone" placeholder="Número de celular" class="w-full" />
                <x-jet-input-error for="phone" />
            </div>
        </div>

        {{-- Ventanas de Envios --}}
        <div x-data="{ envio_type: @entangle('envio_type') }">
            <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold ">Envíos</p>

            {{-- Recojo en tienda --}}
            <label class="bg-white rounded-lg shadow px-6 py-4 flex items-center mb-4">
                <input x-model="envio_type" type="radio" value="1" name="envio_type" id=""
                    class="text-gray-600">
                <span class="ml-2 text-gray-700">Recojo en tienda (Calle 123)</span>

                <span class="semibold text-gray-700 ml-auto">Gratis</span>
            </label>

            {{-- Envio a domicilio --}}
            <div class="bg-white rounded-lg ">
                {{-- Tarjeta de envio a domicilio --}}
                <label class="shadow px-6 py-4 flex items-center">
                    <input x-model="envio_type" type="radio" value="2" name="envio_type" id=""
                        class="text-gray-600">
                    <span class="ml-2 text-gray-700">Envio a domicilio</span>
                </label>

                {{-- Formulario de envio a domicilio --}}
                <div class="px-6 pb-6 mt-6 grid grid-cols-2 gap-6 hidden" :class="{ 'hidden': envio_type != 2 }">
                    {{-- Departamento --}}
                    <div>
                        <x-jet-label value="Departamento" />
                        <select class="form-control w-full" wire:model="department_id">
                            <option value="" disabled selected>Seleccione un departamento</option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="department_id" />
                    </div>

                    {{-- Ciudadees --}}
                    <div>
                        <x-jet-label value="Ciudad" />
                        <select class="form-control w-full" wire:model="city_id">
                            <option value="" disabled selected>Seleccione una ciudad</option>

                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="city_id" />
                    </div>

                    {{-- Distritos --}}
                    <div>
                        <x-jet-label value="Distrito" />
                        <select class="form-control w-full" wire:model="district_id">
                            <option value="" disabled selected>Seleccione una ciudad</option>

                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="district_id" />
                    </div>

                    <div>
                        <x-jet-label value="Direccion" />
                        <x-jet-input class="w-full" wire:model="address" type="text" />
                        <x-jet-input-error for="address" />
                    </div>

                    <div class="col-span-2">
                        <x-jet-label value="Referencia" />
                        <x-jet-input class="w-full" wire:model="references" type="text" />
                        <x-jet-input-error for="references" />
                    </div>
                </div>
            </div>



        </div>



        {{-- Continuar con la compra --}}
        <div>
            <x-jet-button wire:loading.attr="disabled" wire:target="create_order" class="mt-6 mb-4"
                wire:click="create_order">
                Continuar con la compra
            </x-jet-button>
            <hr>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint iste accusamus voluptate maxime ad
                reprehenderit. Ipsa, dicta nemo eligendi debitis in quam cum fugit repellendus distinctio possimus
                soluta ad quis. <a class="text-sm font-semibold text-blue-500 mt-2" href="">Revisar Políticas</a>
            </p>
        </div>
    </div>

    <div class="order-1 lg:order-1 lg:col-span-1 xl:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <ul>
                @forelse (Cart::content() as $item)
                    <li class="flex p-2 border-b border-gray-200">
                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>
                            <div class="flex">
                                <p>Cant: {{ $item->qty }}</p>
                                {{--  si el parametro esta definido lo imprime, sino lo ignora --}}
                                @isset($item->options['color'])
                                    <p class="mx-2">- Color: {{ $item->options['color'] }}</p>
                                @endisset

                                @isset($item->options['size'])
                                    <p class="mx-2">- Talla: {{ $item->options['size'] }}</p>
                                @endisset

                            </div>
                            <p>Precio: {{ $item->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p class="text-center text-gray-700">El carrito está vacio</p>
                    </li>
                @endforelse
            </ul>

            <hr class="mt-4 mb-3">

            <div class="text-gray-700">
                <p class="flex justify-between items-center">
                    Subtotal:
                    <span class="font-semibold">S/ {{ Cart::Subtotal() }}</span>
                </p>
                <p class="flex justify-between items-center">
                    Envio:
                    <span class="font-semibold">
                        @if ($envio_type == 1 || $shipping_cost == 0)
                            Gratis
                        @else
                            S/ {{ $shipping_cost }}
                        @endif
                    </span>
                </p>

                <hr class="mt-4 mb-3">

                <p class="flex justify-between items-center font-semibold">

                    <span class="text-lg">Total:</span>
                    @if ($envio_type == 1)
                        S/ {{ Cart::Subtotal() }}
                    @else
                        S/ {{ Cart::Subtotal() + $shipping_cost }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
