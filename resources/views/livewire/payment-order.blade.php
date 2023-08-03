@php

    // SDK de Mercado Pago
    require base_path('/vendor/autoload.php');
    // Agrega credenciales
    MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();
    $shipments = new MercadoPago\Shipments();

    $shipments->cost = $order->shipping_cost;
    $shipments->mode = 'not_specified';

    $preference->shipments = $shipments;
    // Crea un ítem en la preferencia

    foreach ($items as $producto) {
        $item = new MercadoPago\Item();
        $item->title = $producto->name;
        $item->quantity = $producto->qty;
        $item->unit_price = $producto->price;
        $products[] = $item;
    }
    $preference->back_urls = [
        'success' => route('orders.pay', $order),
        'failure' => route('orders.index'),
        'pending' => route('orders.index'),
    ];
    $preference->auto_return = 'approved';
    $preference->items = $products;
    $preference->save();

@endphp

<div style="margin-top: 2%">
    <div class="container-fluid mb-5">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Inicio</a>
                    <a class="breadcrumb-item text-dark" href="#">Comprar</a>
                    <span class="breadcrumb-item active">Completar Pago</span>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8  mb-5">

            <div class="bg-white rounded-lg shadow-md p-6 text-gray-700 mb-3">
                <p class="text-xl font-semibold mb-4">Resumen</p>

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($items as $item)
                            {{-- el json que decodificamos en el controlador --}}
                            <tr>
                                <td>
                                    <div class="flex">
                                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}"
                                            alt="">
                                        <article>
                                            <h1 class="font-bold">{{ $item->name }}</h1>
                                            <div class="flex text-xs">
                                                @isset($item->options->color)
                                                    Color: {{ $item->options->color }}
                                                @endisset
                                                @isset($item->options->size)
                                                    Color: {{ $item->options->size }}
                                                @endisset

                                            </div>
                                        </article>
                                    </div>
                                </td>
                                <td class="text-center">
                                    S/ {{ $item->price }}
                                </td>
                                <td class="text-center">
                                    {{ $item->qty }}
                                </td>
                                <td class="text-center">
                                    S/ {{ $item->price * $item->qty }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>


            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-gray-700 mb-3">


                <p class="text-xl font-semibold mb-4">Detalles</p>
                <table style="width: 100%">
                    <tr>
                        <td>
                            @if ($order->envio_type == 1)
                                <p class="text-sm">Los productos deben ser recogidos en tienda</p>
                                <p class="text-sm">Calle 123</p>
                            @else
                                <p class="text-sm">Los productos serán enviados a : {{ $envio->address }}</p>

                                <p>{{ $envio->department }} - {{ $envio->city }} - {{ $envio->district }}
                                </p>
                            @endif
                        </td>
                        <td>
                            <p class="text-sm">Persona que recibirá el producto: {{ $order->contact }}</p>
                            <p class="text-sm">Teléfono de contacto: {{ $order->phone }}</p>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3"><span
                        class="font-semibold">Número de orden:</span>
                    S0001{{ $order->id }}</span></h5>
            <div class="bg-light p-30 mb-5">
                <div id="wallet_container"></div>
            </div>


        </div>





    </div>
</div>



@push('script')
    {{-- SDK MercadoPago.js --}}
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}"></script>

    <script>
        const mp = new MercadoPago("{{ config('services.mercadopago.key') }}");
        const bricksBuilder = mp.bricks();
    </script>

    <script>
        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: "{{ $preference->id }}",
            },
        });
    </script>


    <script>
        paypal.Buttons({

            // Sets up the transaction when a payment button is clicked

            createOrder: (data, actions) => {

                return actions.order.create({

                    purchase_units: [{

                        amount: {

                            value: "{{ $order->total }}" // Can also reference a variable or function

                        }

                    }]

                });

            },

            // Finalize the transaction after payer approval

            onApprove: (data, actions) => {


                return actions.order.capture().then(function(orderData) {

                    Livewire.emit('payOrder');
                    /*                     // Successful capture! For dev/demo purposes:

                                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                                        const transaction = orderData.purchase_units[0].payments.captures[0];

                                        alert(
                                            `Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`
                                            );
                     */
                });

            }

        }).render('#paypal-button-container');
    </script>
@endpush
