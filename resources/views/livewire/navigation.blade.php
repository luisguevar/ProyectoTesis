
<header class="sticky top-0 " style="z-index: 900;  background-color: #08769a" x-data="dropdown()">

    <div class=" align-items-center bg-light bg-header-prenav py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-3">
            <a href="/" class="text-decoration-none">

               <h1> <span class="text-uppercase text-logo px-2 ml-n1" style="font-size: 2.5rem;">LOGO AQUÍ</span></h1>
            </a>
        </div>
        <div class="col-lg-7  col-lg-4 col-6 text-left">

            <div class="flex-1 hidden md:block">
                @livewire('search')
            </div>
        </div>
        <div class="col-lg-2 col-6 text-right">
            <div class="mx-6 relative hidden md:block">

                <div>
                    @auth

                        <x-jet-dropdown width="48">
                            <x-slot name="trigger">

                                <div class="flex items-center justify-items-center">
                                    <div class="flex items-center space-x-2">

                                        <p class="text-white mt-3">Hola, <?php echo implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)); ?>!</p>
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </div>
                                </div>


                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link href="{{ route('orders.index') }}">
                                    {{ __('Mis Órdenes') }}
                                </x-jet-dropdown-link>

                                @role('admin')
                                    <x-jet-dropdown-link href="{{ route('admin.index') }}">
                                        {{ __('Administrador') }}
                                    </x-jet-dropdown-link>
                                @endrole

                                <div class="border-t border-gray-100"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-jet-dropdown-link>
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    @else
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <i class="fas fa-user-circle text-white text-3xl cursor-pointer"></i>
                            </x-slot>

                            <x-slot name="content">
                                <x-jet-dropdown-link href="{{ route('login') }}">
                                    {{ __('Login') }}
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </x-jet-dropdown-link>
                            </x-slot>
                        </x-jet-dropdown>
                    @endauth


                </div>



            </div>

        </div>
    </div>
    <nav id="navigation-menu" x-show="open" :class="{ 'block': open, 'hidden': !open }"
        class="bg-trueGray-700 bg-opacity-25 w-full absolute hidden">

        {{-- Menu computadora --}}
        <div x-on:click.away="close()" class="conteiner h-full hidden md:block">
            <div x-show="open" x-on:click.away="open = false" class="grid grid-cols-4 h-full relative">

                <ul class="bg-white">
                    @foreach ($categories as $category)
                        <li class="navigation-link text-trueGray-500 hover:bg-blue-500 hover:text-white">
                            <a href="{{ route('categories.show', $category) }}"
                                class="py-2 px-4 text-sm flex items-center">


                                <span class="flex justify-center w-9">
                                    {!! $category->icon !!}
                                </span>
                                {{ $category->name }}
                            </a>
                            <div class="navigation-submenu bg-gray-100 absolute w-3/4 h-full top-0 right-0 hidden">
                                <x-navigation-subcategories :category="$category" />
                            </div>

                        </li>
                    @endforeach

                </ul>

                <div class="col-span-3 bg-gray-100">
                    <x-navigation-subcategories :category="$categories->first()" />

                </div>
            </div>
        </div>

        {{-- Menu pantalla pequeña --}}
        <div class="bg-white h-full overflow-y-auto">
            <div class="conteiner bg-gray-200 py-2">
                @livewire('search')
            </div>

            <ul>
                @foreach ($categories as $category)
                    <div>
                        <li class=" text-trueGray-500 hover:bg-blue-500 hover:text-white">
                            <a href="{{ route('categories.show', $category) }}"
                                class="py-2 px-4 text-sm flex items-center">
                                <span class="flex justify-center w-9">
                                    {!! $category->icon !!}
                                </span>
                                {{ $category->name }}
                            </a>
                            <div class="navigation-submenu bg-gray-100 absolute w-3/4 h-full top-0 right-0 hidden">
                                <x-navigation-subcategories :category="$category" />
                            </div>

                        </li>
                    </div>
                @endforeach
            </ul>

            <p class="text-trueGray-500 px-6 my-2 ">USUARIOS</p>
            @livewire('cart-mobile')
            @auth
                <a href="{{ route('profile.show') }}"
                    class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-blue-500 hover:text-white">
                    <span class="flex justify-center w-9">
                        <i class="far fa-address-card" aria-hidden="true"></i>
                    </span>
                    Perfil
                </a>

                <a href=""
                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit()"
                    class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-blue-500 hover:text-white">
                    <span class="flex justify-center w-9">
                        <i class="fas fa-sign-out-alt"></i>
                    </span>
                    Cerrar Sesión
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-blue-500 hover:text-white">
                    <span class="flex justify-center w-9">
                        <i class="fas fa-user"></i>
                    </span>
                    Iniciar sesión
                </a>

                <a href="{{ route('register') }}"
                    class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-blue-500 hover:text-white">
                    <span class="flex justify-center w-9">
                        <i class="fas fa-fingerprint"></i>
                    </span>
                    Registrarse
                </a>
            @endauth
        </div>




    </nav>

    <div class="bg-white flex justify-between items-center px-5">
        <div>
            <a :class="{ 'bg-opacity-100 text-blue-500': open }" x-on:click="show()"
                class="flex flex-col items-center order-last md:order-first px-4 bg-white bg-opacity-25 justify-center text-white cursor-pointer font-semibold h-full">
                <span class="container" style="color: gray">Categorias</span>
            </a>
        </div>

        <div class="flex">
            <div class="px-4 py-2">Inicio</div>
            <div class="px-4 py-2">Venta por Teléfono</div>
            <div class="px-4 py-2">Contáctanos</div>
        </div>

        <div class="ml-auto">
            <div class="px-4 py-2">@livewire('dropdow-cart')</div>
        </div>
    </div>




</header>






<!-- Navbar End -->


<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
