<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Floristeria la tata') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url('favicons/favicon.ico') }}">

    <!-- Bootstrap CSS --> 
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zain:wght@200;300;400;700;800;900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@300..700&display=swap" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Lightbox2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">

    <!-- Lightbox2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox-plus-jquery.min.js"></script>


    <!-- boostrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    @php
    if(auth()->check()) {
        $user = auth()->user();

        // Obtener los permisos asociados al rol del usuario
        $permisos_usuario = DB::table('permisos_rol')
                            ->where('id_rol', $user->id_rol)
                            ->pluck('id_permiso')
                            ->toArray();

        // Obtener los IDs de los permisos específicos
        $permiso_roles_id = DB::table('permisos')->where('nombre', 'roles')->value('id');
        $permiso_usuarios_id = DB::table('permisos')->where('nombre', 'usuarios')->value('id');
        $permiso_dashboard_id = DB::table('permisos')->where('nombre', 'dashboard')->value('id');
        $permiso_pedidos_id = DB::table('permisos')->where('nombre', 'pedidos')->value('id');
        $permiso_proveedores_id = DB::table('permisos')->where('nombre', 'proveedores')->value('id');
        $permiso_categorias_productos_id = DB::table('permisos')->where('nombre', 'categorias_productos')->value('id');
        $permiso_categoria_insumos_id = DB::table('permisos')->where('nombre', 'categoria_insumos')->value('id');
        $permiso_insumos_id = DB::table('permisos')->where('nombre', 'insumos')->value('id');
        $permiso_productos_id = DB::table('permisos')->where('nombre', 'productos')->value('id');
        $permiso_compras_id = DB::table('permisos')->where('nombre', 'compras')->value('id');
        $permiso_detalle_venta_id = DB::table('permisos')->where('nombre', 'detalle_venta')->value('id');
        $permiso_pedidos_id = DB::table('permisos')->where('nombre', 'pedidos')->value('id');
        $permiso_pqrs_id = DB::table('permisos')->where('nombre', 'pqrs')->value('id');
        $permiso_envio_id = DB::table('permisos')->where('nombre', 'envio')->value('id');
        
        // Depuración para ver los permisos que tiene el rol actual
        //dd($permisos_usuario);  // Esto mostrará en pantalla los permisos del usuario actual.
    }
@endphp


<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto"></ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto d-flex align-items-center">

                    <!-- Notificaciones -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @if(auth()->check())
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <i class="fa fa-bell bell-icon" style="font-size: 1rem;"></i> 
                                    <span class="badge badge-light" style="font-size: 1rem;">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span> 
                                @else
                                    <i class="fa fa-bell bell-icon" style="font-size: 1rem;"></i> 
                                    <span class="badge badge-light" style="font-size: 1rem; ">0</span> 
                                @endif
                            @else
                                <i class="fa fa-bell bell-icon" style="font-size: 1rem;"></i> 
                                <span class="badge badge-light" style="font-size: 1rem;">0</span> 
                            @endif
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if(auth()->check())
                                @php
                                    $notifications = auth()->user()->unreadNotifications->take(6);
                                @endphp
                                @forelse($notifications as $notification)
                                    <a class="dropdown-item" href="{{ $notification->data['url'] ?? '#' }}">
                                        Pedido #{{ $notification->data['pedido_id'] }}: {{ $notification->data['mensaje'] }}
                                    </a>
                                @empty
                                    <a class="dropdown-item" href="#">No tienes notificaciones.</a>
                                @endforelse
                            @else
                                <a class="dropdown-item" href="#">No estás registrado.</a>
                            @endif
                        </div>
                    </li>

                    <!-- Logo del carrito -->
                    <li class="nav-item position-relative me-4">
                        <a class="nav-link d-flex align-items-center position-relative" href="{{ route('home/carrito') }}">
                            <i class="fas fa-shopping-cart" style="color: #5c5353; font-size: 1rem;"></i> <!-- Aumentar tamaño del carrito -->
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ Cart::content()->count() }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </a>
                    </li>   

                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(auth()->check() && (in_array($permiso_roles_id, $permisos_usuario) || in_array($permiso_usuarios_id, $permisos_usuario) || in_array($permiso_dashboard_id, $permisos_usuario) || in_array($permiso_pedidos_id, $permisos_usuario) || in_array($permiso_proveedores_id, $permisos_usuario) || in_array($permiso_categorias_productos_id, $permisos_usuario) || in_array($permiso_categoria_insumos_id, $permisos_usuario) || in_array($permiso_insumos_id, $permisos_usuario) || in_array($permiso_productos_id, $permisos_usuario) || in_array($permiso_compras_id, $permisos_usuario) || in_array($permiso_detalle_venta_id, $permisos_usuario) || in_array($permiso_pedidos_id, $permisos_usuario) || in_array($permiso_pqrs_id, $permisos_usuario) || in_array($permiso_envio_id, $permisos_usuario)))
                            
                                <a class="dropdown-item" href="{{ route('admin.inicio') }}">Mis funciones</a>
                                
                                @endif
                                <a class="dropdown-item" href="{{ route('perfilUser') }}">
                                    {{ __('Perfil') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</div>


<!-- Bootstrap JS -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/flor.js') }}"></script>


<!--carrusel -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Livewire Scripts -->
@livewireScripts

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</body>
</html>
