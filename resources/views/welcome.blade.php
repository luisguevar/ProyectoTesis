<x-app-layout>
    
    <div class="conteiner py-8 ">
        @foreach ($categories as $category)
        <section class="mb-6">
           <div class="flex items-center mb-2"> {{-- flex para colocarlo al costado --}}
                <h1 class="text-lg uppercase font-bold text-gray-600">
                    {{$category->name}}
                </h1>
                <a href="{{route('categories.show', $category)}}" class="text-blue-500  hover:text-blue-400 hover:underline ml-2 font-semibold">Ver más</a>
           </div>

            @livewire('category-products', ['category' => $category])
        </section> 
        @endforeach

    </div>

    @push('script')
    <script>
        Livewire.on('glider', function(id)
        {
            new Glider(document.querySelector('.glider-' +id), {
            slidesToShow: 1,//cantidad de productos a mostrar
            slidesToScroll: 1, //cantidad de productos a desplazar
            draggable: true,
            dots: '.glider-' +id + '~.dots',
            arrows: {
            prev: '.glider-' +id +'~.glider-prev',
            next: '.glider-' +id +'~.glider-next'
        
         },
         responsive:[
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 2.5,//cantidad de productos a mostrar
                    slidesToScroll: 2, //cantidad de productos a desplazar
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3.5,//cantidad de productos a mostrar
                    slidesToScroll: 3, //cantidad de productos a desplazar
                },
            },
            
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4.5,//cantidad de productos a mostrar
                    slidesToScroll: 4, //cantidad de productos a desplazar
                },
            },
            

            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 5.5,//cantidad de productos a mostrar
                    slidesToScroll: 5, //cantidad de productos a desplazar
                },
            },
            
         ]

        });
        });
    </script> 
    @endpush

</x-app-layout>