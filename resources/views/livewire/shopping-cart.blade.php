<div class="container-fluid">
    <div style="margin-top: 2%">
        <div class="container-fluid mb-5">
            <div class="row px-xl-5">
                <div class="col-12">
                    <nav class="breadcrumb bg-light mb-30">
                        <a class="breadcrumb-item text-dark" href="#">Home</a>
                        <a class="breadcrumb-item text-dark" href="#">Compras</a>
                        <span class="breadcrumb-item active">Carrito de Compras</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @if (Cart::count())
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">

                            @foreach (Cart::content() as $item)
                                <tr>
                                    <td class="align-middle">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover object-center"
                                                    src="{{ $item->options->image }}" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    @if ($item->options->color)
                                                        <span>
                                                            Color: {{ __($item->options->color) }}
                                                        </span>
                                                    @endif

                                                    @if ($item->options->size)
                                                        <span class="mx-1">-</span>

                                                        <span>
                                                            {{ $item->options->size }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">S/ {{ $item->price }}</td>
                                    <td class="align-middle">
                                        <div class="text-sm text-gray-500">
                                            @if ($item->options->size)
                                                @livewire('update-cart-item-size', ['rowId' => $item->rowId], key($item->rowId))
                                            @elseif($item->options->color)
                                                @livewire('update-cart-item-color', ['rowId' => $item->rowId], key($item->rowId))
                                            @else
                                                @livewire('update-cart-item', ['rowId' => $item->rowId], key($item->rowId))
                                            @endif
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="text-sm text-gray-500">
                                            S/ {{ $item->price * $item->qty }}
                                        </div>
                                    </td>
                                    <td class="align-middle"> <a class="ml-6 cursor-pointer hover:text-red-600"
                                            wire:click="delete('{{ $item->rowId }}')"
                                            wire:loading.class="text-red-600 opacity-25"
                                            wire:target="delete('{{ $item->rowId }}')">
                                            <i class="fas fa-trash"></i>
                                        </a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="px-6 py-4">
                        <a class="text-sm cursor-pointer hover:underline mt-3 inline-block" wire:click="destroy">
                            <i class="fas fa-trash"></i>
                            Vaciar carrito
                        </a>
                    </div>

                </div>

                <div class="col-lg-4">
                    <form class="mb-30" action="">
                        <div class="input-group">
                            <input type="text" class="form-control border-0 p-4" placeholder="Código Descuento">
                            <div class="input-group-append">
                                <button class="btn btn-primary">Aplicar Cupón</button>
                            </div>
                        </div>
                    </form>
                    <h5 class="section-title position-relative text-uppercase mb-3"><span
                            class="bg-secondary pr-3">Resumen de Pago</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6> S/ {{ Cart::subTotal() }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Recojo en Local:</h6>
                                <h6 class="font-weight-medium">Gratis</h6>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5> S/ {{ Cart::subTotal() }}</h5>
                            </div>

                            <a href="{{ route('orders.create') }}" style="text-decoration: none"><button
                                    class="btn btn-block btn-primary font-weight-bold my-3 py-3 ">Proceder a
                                    Pagar</button></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center">
            <x-cart />
            <p class="text-lg text-gray-700 mt-4">TU CARRO DE COMPRAS ESTÁ VACÍO</p>

            <x-button-enlace href="/" class="mt-4 px-16">
                Ir al inicio
            </x-button-enlace>
        </div>
    @endif

    <!-- This example requires Tailwind CSS v2.0+ -->


    {{--
    @if (Cart::count())
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mt-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-700">
                        <span class="font-bold text-lg">Total:</span>
                        S/ {{ Cart::subTotal() }}
                    </p>
                </div>

                <div>
                    <x-button-enlace href="{{ route('orders.create') }}">
                        Continuar
                    </x-button-enlace>
                </div>
            </div>
        </div>
    @endif
 --}}
</div>
