<x-admin-layout>
    <div class="conteiner py-12">

        {{-- BLOQUES DE ESTADOS DE LAS ORDENES --}}

        <section class="grid md:grid-cols-4 gap-6 text-white">


            <a href="{{ route('admin.orders.index') . '? status=2' }}"
                class="bg-gray-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl ">
                    {{ $recibido }}
                </p>
                <p class="uppercase text-2xl mt-2 text-center">Recibido</p>
                <p class="text-center text-2xl ">
                    <i class="fas fa-credit-card"></i>
                </p>
            </a>

            <a href="{{ route('admin.orders.index') . '? status=3' }}"
                class="bg-yellow-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl ">
                    {{ $enviado }}
                </p>
                <p class="uppercase text-2xl mt-2 text-center">Enviado</p>
                <p class="text-center text-2xl ">
                    <i class="fas fa-truck"></i>
                </p>
            </a>

            <a href="{{ route('admin.orders.index') . '? status=4' }}"
                class="bg-green-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl ">
                    {{ $entregado }}
                </p>
                <p class="uppercase text-2xl mt-2 text-center">Entregado</p>
                <p class="text-center text-2xl ">
                    <i class="fas fa-check-circle"></i>
                </p>
            </a>

            <a href="{{ route('admin.orders.index') . '? status=5' }}"
                class="bg-red-500 bg-opacity-75 rounded-lg px-12 pt-8 pb-4">
                <p class="text-center text-2xl ">
                    {{ $anulado }}
                </p>
                <p class="uppercase text-2xl mt-2 text-center">Anulado</p>
                <p class="text-center text-2xl ">
                    <i class="fas fa-times-circle"></i>
                </p>
            </a>

        </section>

        @if ($orders->count())
            <section class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
                <h1 class="text-2xl mb-4">Pedidos recientes</h1>
                <ul>

                    {{-- RECUPERAR LAS ORDENES --}}
                    @foreach ($orders as $order)
                        <li>
                            <a href="{{ route('admin.orders.show', $order) }}"
                                class="flex items-center py-2 px-4 hover:bg-gray-100">
                                {{--  ICONOS DE LAS ORDENES --}}
                                <span class="w-12 text-center">
                                    @switch($order->status)
                                        @case(1)
                                            <i class="fas fa-business-time text-pink-500 opacity-50"></i>
                                        @break

                                        @case(2)
                                            <i class="fas fa-credit-card text-gray-500 opacity-50"></i>
                                        @break

                                        @case(3)
                                            <i class="fas fa-truck text-yellow-500 opacity-50"></i>
                                        @break

                                        @case(4)
                                            <i class="fas fa-check-circle text-green-500 opacity-50"></i>
                                        @break

                                        @case(5)
                                            <i class="fas fa-times-circle text-red-500 opacity-50"></i>
                                        @break

                                        @default
                                    @endswitch
                                </span>

                                {{--  NOMBRE DE LAS ORDENES --}}
                                <span>
                                    Order: {{ $order->id }}
                                    <br>
                                    {{ $order->created_at->format('d/m/Y') }}
                                </span>

                                {{--  ESTADO Y PRECIO DE LAS ORDENES --}}
                                <div class="ml-auto ">
                                    <span class="font-bold">
                                        @switch($order->status)
                                            @case(1)
                                                Pendiente
                                            @break

                                            @case(2)
                                                Recibido
                                            @break

                                            @case(3)
                                                Enviado
                                            @break

                                            @case(4)
                                                Entregado
                                            @break

                                            @case(5)
                                                Anulado
                                            @break

                                            @default
                                        @endswitch
                                    </span>
                                    <br>
                                    <span class="text-sm">
                                        S/ {{ $order->total }}
                                    </span>
                                </div>

                                {{--  ICONO PARA VIAJAR A LA ORDEN --}}
                                <span>
                                    <i class="fas fa-angle-right ml-6"></i>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @else
            <div class="bg-white shadow-lg rounded-lg px-12 py-8 mt-12 text-gray-700">
                <span class="font-bold text-lg">No existen registros de órdenes</span>
            </div>
        @endif
    </div>
</x-admin-layout>
