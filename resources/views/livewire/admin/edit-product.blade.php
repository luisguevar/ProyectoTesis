<div>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 ">
            <div class="flex justify-between items-center">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight ">Productos</h1>
                <x-jet-danger-button wire:click="$emit('deleteProduct')">
                    Eliminar
                </x-jet-danger-button>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
        <h1 class="text-3xl text-center font-semibold mb-8">Complete esta información para crear un producto</h1>

        {{-- Dropzone --}}
        <div class="mb-4" wire:ignore> {{-- No se renderice - ignore --}}
            <form action="{{ route('admin.products.files', $product) }}" method="POST" class="dropzone"
                id="my-awesome-dropzone"></form>
        </div>

        {{-- Imagenes --}}
        @if ($product->images->count())
            <section class="bg-white shadow-xl rounded-lg p-6 mb-4">
                <h1 class="text-2xl text-center font-semibold mb-2">Imágenes del producto</h1>
                <ul class="flex flex-wrap">
                    @foreach ($product->images as $image)
                        <li class="relative" wire:key="image-{{ $image->id }}">
                            <img class="w-32 h-20 object-cover" src="{{ Storage::url($image->url) }}" alt="">
                            <x-jet-danger-button class="absolute right-2 top-2"
                                wire:click="deleteImage({{ $image->id }})" wire:loading.attr="disabled"
                                wire:target="deleteImage({{ $image->id }})">
                                x
                            </x-jet-danger-button>
                        </li>
                    @endforeach
                </ul>
            </section>

        @endif

        {{-- status --}}
        @livewire('admin.status-product', ['product' => $product], key('status-product' . $product->id))

        <div class="bg-white shadow-xl rounded-lg p-6">
            <div class="grid grid-cols-2 gap-6 mb-4">

                {{-- CATEGORIAS --}}

                <div>
                    <x-jet-label value="Categorias"></x-jet-label>
                    <select name="" id="" class="w-full form-control" wire:model="category_id">
                        <option value="" selected disabled>Seleccione una categoria</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>

                    <x-jet-input-error for="category_id" />
                </div>

                {{-- SUBCATEGORIAS --}}

                <div>
                    <x-jet-label value="Subcategorias"></x-jet-label>
                    <select name="" id="" class="w-full form-control"
                        wire:model="product.subcategory_id">
                        <option value="" selected disabled>Seleccione una categoria</option>

                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach

                    </select>
                    <x-jet-input-error for="product.subcategory_id" />
                </div>
            </div>

            {{-- Nombre --}}
            <div class="mb-4">
                <x-jet-label value="Nombre" />
                <x-jet-input type="text" class="w-full" wire:model="product.name"
                    placeholder="Ingrese el nombre del producto" />

                <x-jet-input-error for="product.name" />
            </div>

            {{-- Slug --}}
            <div class="mb-4">
                <x-jet-label value="Slug" />
                <x-jet-input type="text" class="w-full bg-gray-200" disabled wire:model="slug"
                    placeholder="Ingrese el slug del producto" />

                <x-jet-input-error for="slug" />
            </div>

            {{-- Descripcion --}}
            <div class="mb-4">
                <div wire:ignore>
                    <x-jet-label value="Descripcion" />
                    <textarea class="w-full form-control" rows="10" wire:model="product.description" x-data x-init="    ClassicEditor
                            .create($refs.miEditor)
                    
                            .then(function(editor) {
                                editor.model.document.on('change:data', () => {
                                    @this.set('product.description', editor.getData())
                                })
                            })
                            .catch(error => {
                                console.error(error);
                            });"
                        x-ref="miEditor">
                    </textarea>
                </div>
                <x-jet-input-error for="product.description" />
            </div>

            {{-- Marca y precio --}}
            <div class="grid grid-cols-2 mb-4 gap-6">

                {{-- Marcas --}}
                <div>
                    <x-jet-label value="Marca" />
                    <select class="form-control w-full" wire:model="product.brand_id">
                        <option value="" selected disabled>Seleccione una marca</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>

                    <x-jet-input-error for="product.brand_id" />
                </div>

                {{-- Precio --}}
                <div>
                    <x-jet-label value="Precio" />
                    <x-jet-input wire:model="product.price" type="number" class="w-full" step=".01" />
                    <x-jet-input-error for="product.price" />
                </div>

            </div>

            {{-- Propiedad computada --}}

            @if ($this->subcategory)


                @if (!$this->Subcategory->color && !$this->Subcategory->size)
                    {{-- Para el valor color 0 y size 0 --}}
                    {{-- Precio --}}
                    <div>
                        <x-jet-label value="Cantidad" />
                        <x-jet-input wire:model="product.quantity" type="number" class="w-full" />

                        <x-jet-input-error for="product.quantity" />
                    </div>
                @endif

            @endif

            {{-- Botón --}}

            <div class="flex justify-end items-center mt-4">

                <x-jet-action-message class="mr-3" on="saved">
                    ¡Actualizado!
                </x-jet-action-message>

                <x-jet-button wire:loading.attr="disabled" {{-- mientras se ejecuta, se deshabilita --}} wire:target="save" wire:click="save">
                    Actualizar Producto
                </x-jet-button>
            </div>
        </div>

        @if ($this->subcategory)
            @if ($this->subcategory->size)
                @livewire('admin.size-product', ['product' => $product], key('size-product' . $product->id))
            @elseif($this->subcategory->color)
                @livewire('admin.color-product', ['product' => $product], key('color-product' . $product->id))
            @endif
        @endif


    </div>

    @push('script')
        <script>
            Dropzone.options.myAwesomeDropzone = { // camelized version of the `id`
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dictDefaultMessage: "Arrastre una imagen al recuadro",
                acceptedFiles: 'image/*',
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 2, // MB
                complete: function(file) {
                    this.removeFile(file);
                },
                queuecomplete: function() {
                    Livewire.emit('refreshProduct');
                }
            };

            Livewire.on('deleteSize', sizeId => {
                /* evento */

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        /* otro evento */

                        Livewire.emitTo('admin.size-product', 'delete',
                            sizeId); /* este evento lo escuchamos desde el componente */
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })

            Livewire.on('deletePivot', pivot => {
                /* evento */

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        /* otro evento */

                        Livewire.emitTo('admin.color-product', 'delete',
                            pivot); /* este evento lo escuchamos desde el componente */
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })

            Livewire.on('deleteProduct', () => {
                /* evento */

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        /* otro evento */

                        Livewire.emitTo('admin.edit-product', 'delete'); /* este evento lo escuchamos desde el componente */
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })

            Livewire.on('deleteColorSize', pivot => {
                /* evento */

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        /* otro evento */

                        Livewire.emitTo('admin.color-size', 'delete',
                            pivot); /* este evento lo escuchamos desde el componente */
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })

        </script>
    @endpush
</div>
