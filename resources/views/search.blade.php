<x-app-layout>
    <div class="conteiner py-8">
        <div class="mt-4">
            {{$products->links()}}
        </div>

        <ul>
            <li class="bg-white rounded-lg shadow-lg mb-6 mt-4">
                <div class=" text-left text-gray-700 p-4">Posibles Resultados:</div>
            </li>
            @forelse ($products as $product)
            
                <x-products-list :product="$product" />
            @empty

                            
            @endforelse
        </ul>
        <div class="mt-4">
            {{$products->links()}}
        </div>

    </div>


</x-app-layout>
