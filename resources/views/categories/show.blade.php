<x-app-layout>
    <div class="conteiner py-8">
        <figure class="mb-4"> {{-- mb para la separacion --}}
         {{--   imagen dimensionada --}}
            <img  class="w-full h-80 object-cover object-center" src="{{Storage::url($category->image)}}" alt="">
        </figure>

        @livewire('category-filter', ['category' => $category])
    </div>

</x-app-layout>