<x-app-layout>

    <!-- Breadcrumb Start -->

    <div style="margin-top: 2%">
        <div class="container-fluid mb-5">
            <div class="row px-xl-5">
                <div class="col-12">
                    <nav class="breadcrumb bg-light mb-30">
                        <a class="breadcrumb-item text-dark" href="#">Home</a>
                        <a class="breadcrumb-item text-dark" href="#">{{ $subcategoryName }}</a>
                        <span class="breadcrumb-item active">{{ $product->name }}</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light" style="height: 520px;">
                        <div class="flexslider">
                            <ul class="slides">
                                @foreach ($product->images as $image)
                                    <li data-thumb="{{ Storage::url($image->url) }}">
                                        <img src="{{ Storage::url($image->url) }}" />
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3 class="text-xl">{{ $product->name }}</h3>
                    <div class="d-flex mb-3">
                        <p class=" font-semibold text-trueGray-700 ">Marca: <a
                                class="underline capitalize cursor-pointer hover:text-blue-500"
                                href="">{{ $product->brand->name }}</a></p>
                        <p class=" text-trueGray-700 mx-6"> {{ round($product->reviews->avg('rating'), 1) }} <i
                                class="fas fa-star text-sm text-yellow-400"></i> </p>
                        <p class=" text-blue-500 underline ml-6 cursor-pointer hover:text-blue-700">Reseñas:
                            {{ $product->reviews->count() }} </p>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">s/. {{ $product->price }}</h3>

                    {{--   <div class="">

                        <p>Recíbelo el {{ Date::now()->addDay(7)->locale('es')->format('l j F') }}</p>
                    </div> --}}
                    <div class="bg-white rounded-lg shadow-md mb-6">
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

    </div>

    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-12 mb-30">
                <div class="col-md-12 bg-light p-30">
                    <div class="nav nav-tabs">
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-1">Information</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Reviews
                            ({{ $product->reviews->count() }})</a>
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane fade" id="tab-pane-1">
                            <h4 class="mb-4 mt-4">Additional Information</h4>
                            <p> {!! $product->description !!}
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <div class="row">
                                {{-- Reseña --}}

                                @can('review', $product)
                                    <div style="width: 100%" class="text-gray-700 mt-4">
                                        <h2 class="font-bold text-lg">Reseñas</h2>


                                        <form action="{{ route('reviews.store', $product) }}" method="POST">
                                            @csrf

                                            <textarea name="comment" id="editor"></textarea>
                                            <x-jet-input-error for="comment" />

                                            <div class="flex items-center mt-2" x-data="{ rating: 5 }">
                                                <p class="font-semibold mr-3">Calificación</p>
                                                <ul class="flex space-x-2">
                                                    <li x-bind:class="rating >= 1 ? 'text-yellow-500' : ''">
                                                        <button type="button" class="focus:outline-none"
                                                            x-on:click="rating = 1">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </li>
                                                    <li x-bind:class="rating >= 2 ? 'text-yellow-500' : ''">
                                                        <button type="button" class="focus:outline-none"
                                                            x-on:click="rating = 2">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </li>
                                                    <li x-bind:class="rating >= 3 ? 'text-yellow-500' : ''">
                                                        <button type="button" class="focus:outline-none"
                                                            x-on:click="rating = 3">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </li>
                                                    <li x-bind:class="rating >= 4 ? 'text-yellow-500' : ''">
                                                        <button type="button" class="focus:outline-none"
                                                            x-on:click="rating = 4">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </li>
                                                    <li x-bind:class="rating >= 5 ? 'text-yellow-500' : ''">
                                                        <button type="button" class="focus:outline-none"
                                                            x-on:click="rating = 5">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </li>
                                                </ul>

                                                <x-jet-button class="ml-auto"
                                                    style="background-color: #08769a; color: white;">Agregar
                                                    reseña</x-jet-button>

                                                <input class="hidden" name="rating" type="number" x-model="rating">
                                            </div>
                                        </form>
                                    </div>
                                @endcan
                                {{-- Reseñas lista --}}

                                @if ($product->reviews->isNotEmpty())
                                    <div class="mt-6 text-gray-700">
                                        <h2 class="font-bold text-lg">Reseñas</h2>

                                        <div class="mt-2 w-full">
                                            @foreach ($product->reviews as $review)
                                                <div class="flex">
                                                    {{-- Foto --}}
                                                    <div class="flex-shrink-0">
                                                        <img class="w-10 h-10 rounded-full object-cover mr-4 "
                                                            src="{{ $review->user->profile_photo_url }}"
                                                            alt="{{ $review->user->name }}">
                                                    </div>


                                                    <div class="flex-1">
                                                        <p class="font-semibold">{{ $review->user->name }}</p>
                                                        <p class="text-sm">{{ $review->created_at->diffForHumans() }}
                                                        </p>
                                                        <div>
                                                            {!! $review->comment !!}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p>
                                                            {{ $review->rating }}
                                                            <i class="fas fa-star text-yellow-500"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
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
        <!-- JavaScript Libraries -->

        {{--  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script> --}}
    @endpush
</x-app-layout>
