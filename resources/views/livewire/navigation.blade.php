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


    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">

        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse"
                    href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">

                        @foreach ($categories as $category)
                            <div class="nav-item dropdown dropright">
                                <a href="#" class="nav-link dropdown-toggle"
                                    data-toggle="dropdown">{{ $category->name }} <i
                                        class="fa fa-angle-right float-right mt-1"></i></a>
                                <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                    @foreach ($category->subcategories as $subcategory)
                                        <a href="{{ route('categories.show', $category) . '?subcategoria=' . $subcategory->slug }}"
                                            class="dropdown-item">{{ $subcategory->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse"
                        style="background-color: rgb(125, 124, 124);  border-radius: 5px;">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.html" class="nav-item nav-link">Header 1</a>
                            <a href="detail.html" class="nav-item nav-link">Header 2</a>
                            <a href="contact.html" class="nav-item nav-link">Header 3</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            {{--  <a href="" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle"
                                    style="padding-bottom: 2px;">0</span>
                            </a> --}}
                            <span class="btn px-0 ml-3">
                                @livewire('dropdow-cart')
                            </span>

                        </div>
                    </div>
                </nav>
            </div>
        </div>

    </div>
    <!-- Navbar End -->





</header>

@push('script')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
@endpush
