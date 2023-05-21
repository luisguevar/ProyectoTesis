<x-app-layout>
    <div class="conteiner py-8">
        {{-- GRID DE 2 COLUMNAS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            {{-- SLIDER --}}
            <div class="">
                <div class="flexslider">
                    <ul class="slides">
                        @foreach ($product->images as $image)
                            <li data-thumb="{{ Storage::url($image->url) }}">
                                <img src="{{ Storage::url($image->url) }}" />
                            </li>
                        @endforeach

                    </ul>
                </div>
                <div class="-mt-10 text-gray-700">
                    <h2 class="font-bold text-lg">Descripcion</h2>
                    {!!$product->description!!}
                </div>

                {{-- Reseña --}}

                @can('review', $product)
                    <div class="text-gray-700 mt-4">
                        <h2 class="font-bold text-lg">Reseñas</h2>


                        <form action="{{route('reviews.store', $product)}}" method="POST">
                            @csrf

                            <textarea name="comment" id="editor"></textarea>
                            <x-jet-input-error for="comment" />

                            <div class="flex items-center mt-2" x-data="{ rating: 5 }">
                                <p class="font-semibold mr-3">Calificación</p>
                                <ul class="flex space-x-2">
                                    <li x-bind:class="rating >= 1 ? 'text-yellow-500' : ''">
                                        <button type="button" class="focus:outline-none" x-on:click="rating = 1">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </li>
                                    <li x-bind:class="rating >= 2 ? 'text-yellow-500' : ''">
                                        <button type="button" class="focus:outline-none" x-on:click="rating = 2">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </li>
                                    <li x-bind:class="rating >= 3 ? 'text-yellow-500' : ''">
                                        <button type="button" class="focus:outline-none" x-on:click="rating = 3">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </li>
                                    <li x-bind:class="rating >= 4 ? 'text-yellow-500' : ''">
                                        <button type="button" class="focus:outline-none" x-on:click="rating = 4">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </li>
                                    <li x-bind:class="rating >= 5 ? 'text-yellow-500' : ''">
                                        <button type="button" class="focus:outline-none" x-on:click="rating = 5">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </li>
                                </ul>

                                <x-jet-button class="ml-auto">Agregar reseña</x-jet-button>

                                <input class="hidden" name="rating" type="number" x-model="rating">
                            </div>
                        </form>
                    </div>
                @endcan

                {{-- Reseñas lista --}}

                @if ($product->reviews->isNotEmpty())
                    <div class="mt-6 text-gray-700">
                        <h2 class="font-bold text-lg">Reseñas</h2>
                        
                        <div class="mt-2">
                            @foreach ($product->reviews as $review)
                                <div class="flex">
                                    {{-- Foto --}}
                                    <div class="flex-shrink-0">
                                        <img class="w-10 h-10 rounded-full object-cover mr-4 " src="{{$review->user->profile_photo_url}}" alt="{{$review->user->name}}">
                                    </div>


                                    <div class="flex-1">
                                        <p class="font-semibold">{{$review->user->name}}</p>
                                        <p class="text-sm">{{$review->created_at->diffForHumans()}}</p>
                                        <div>
                                            {!! $review->comment !!}
                                        </div>
                                    </div>
                                    <div>
                                        <p>
                                            {{$review->rating}}
                                            <i class="fas fa-star text-yellow-500"></i>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
               
                @endif


            </div>



            {{-- INFORMACIÓN DEL PROD Y ENVIO --}}
            <div>
                <h1 class="text-lg font-bold text-trueGray-700 ">{{ $product->name }}</h1>
                <div class="flex">
                    <p class=" font-semibold text-trueGray-700 ">Marca: <a
                            class="underline capitalize cursor-pointer hover:text-blue-500"
                            href="">{{ $product->brand->name }}</a></p>
                    <p class=" text-trueGray-700 mx-6"> {{round($product->reviews->avg('rating'),1 )}} <i class="fas fa-star text-sm text-yellow-400"></i> </p>
                    <p class=" text-blue-500 underline ml-6 cursor-pointer hover:text-blue-700">Reseñas: {{$product->reviews->count()}} </p>
                </div>

                <p class="text-2xl font-semibold text-trueGray-700 my-4"> S/ {{ $product->price }}</p>
                <div class="bg-white rounded-lg shadow-lg mb-6">
                    <div class="p-4 flex items-center">
                        <span class="flex items-center justify-center h-10 w-10 rounded-full bg-green-400">
                            <i class="fas fa-truck text-sm"></i>
                        </span>

                        <div class="ml-4">
                            <p class="text-lg font-bold text-green-400">Se hace envios a todos el Perú</p>
                            <p>Recibelo el {{ Date::now()->addDay(7)->locale('es')->format('l j F') }}</p>
                        </div>
                    </div>
                </div>

                @if ($product->subcategory->size)
                    {{-- si size es 'true' --}}
                    @livewire('add-cart-item-size', ['product' => $product])
                @elseif ($product->subcategory->color)
                    {{-- si color es 'true' --}}
                    @livewire('add-cart-item-color', ['product' => $product])
                @else
                    @livewire('add-cart-item', ['product' => $product])
                @endif
            </div>


        </div>
    </div>

    {{-- SCRIPT NECESARIO PARA EL SLIDER --}}
    @push('script')
        <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],

                })
                .catch(error => {
                    console.log(error);
                });
        </script>
        <script>
            $(document).ready(function() { //Para que se ejecute luego de que la pagina cargue
                $('.flexslider').flexslider({
                    animation: "slide",
                    controlNav: "thumbnails"
                });
            });
        </script>
    @endpush
</x-app-layout>
