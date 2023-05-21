@php

require base_path('/vendor/autoload.php');
// Agrega credenciales
MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

//objeto para el costo de envio
$shipments = new MercadoPago\Shipments();
$shipments->cost = $order->shipping_cost;
$shipments->mode = 'not_specified';

$preference->shipments = $shipments;

// Crea un ítem en la preferencia
foreach ($items as $product) {
    $item = new MercadoPago\Item();
    $item->title = $product->name;
    $item->quantity = $product->qty;
    $item->unit_price = $product->price;

    $products[] = $item;
}
$preference = new MercadoPago\Preference();
//...
$preference->back_urls = [
    'success' => route('orders.pay', $order),
    'failure' => 'http://www.tu-sitio/failure',
    'pending' => 'http://www.tu-sitio/pending',
];
$preference->auto_return = 'approved';
// ...
$preference->items = $products;
$preference->save();

@endphp

<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 gap-6 conteiner py-8">
    {{-- Contenido --}}
    <div class="order-2 lg:order-1 xl:col-span-3">
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
            <p class="text-gray-700 uppercase"><span class="font-semibold">Número de orden:</span>
                Orden-{{ $order->id }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-2 gap-6 text-gray-700">
                <div>
                    <p class="text-lg font-semibold uppercase">Envío</p>

                    @if ($order->envio_type == 1)
                        <p class="text-sm">Los productos deben ser recogidos en tienda</p>
                        <p class="text-sm">Calle 123</p>
                    @else
                        <p class="text-sm">Los productos serán enviados a:</p>
                        <p class="text-sm"> {{ $envio->address }}</p>
                        <p>{{ $envio->department }} - {{ $envio->city }} - {{ $envio->district }}
                        </p>
                    @endif


                </div>

                <div>
                    <p class="text-lg font-semibold uppercase">Datos de contacto</p>

                    <p class="text-sm">Persona que recibirá el producto: {{ $order->contact }}</p>
                    <p class="text-sm">Teléfono de contacto: {{ $order->phone }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 text-gray-700 mb-6">
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


    </div>

    {{-- Total a pagar --}}

    <div class="order-1 lg:order-2 xl:col-span-2">
        <div class="bg-white rounded-lg shadow-lg px-6 pt-6 ">
            <div class=" flex justify-between items-center mb-4">
                <img class="h-15 w-60" src="{{ asset('img/images.png') }}" alt="">
                <div class="text-gray-700">
                    <p class="text-sm font-semibold">
                        Subtotal: S/ {{ $order->total - $order->shipping_cost }}
                    </p>

                    <p class="text-sm font-semibold">
                        Envio: S/ {{ $order->shipping_cost }}
                    </p>

                    <p class="text-lg font-semibold uppercase">
                        Pago: S/ {{ $order->total }}
                    </p>


                    {{--  <div class="cho-container mt-4"></div> --}}


                </div>

            </div>
            <div id="paypal-button-container"></div>
        </div>

    </div>

</div>

@push('script')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}"></script>

    <script>
        const mp = new MercadoPago("{{ config('services.mercadopago.key') }}", {
            locale: 'es-AR'
        });

        mp.checkout({
            preference: {
                id: '{{ $preference->id }}'
            },
            render: {
                container: '.cho-container',
                label: 'Pagar',
            }
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
