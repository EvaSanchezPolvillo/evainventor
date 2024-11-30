<nav class="navbar navbar-expand-lg bg-body-tertiary" aria-label="Tenth navbar example">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample08"
                aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
            @auth
            <ul class="navbar-nav w-100 mx-auto">
                <li class="nav-item flex-fill mx-2">
                    <a class="navbar-brand" href="#">
                        <img style="width:50px;height:auto" src="{{ asset('storage/logo.png') }}" class="img-responsive">
                    </a>
                </li>

                @can("article-list")
                <li class="nav-item flex-fill mx-2">
                    <a class="nav-link {{ request()->routeIs('articles.index') ? 'active' : '' }}" href="{{ route('articles.index') }}">Artículos</a>
                </li>
                @endcan
                @can("category-list")
                <li class="nav-item flex-fill mx-2">
                    <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">Categorías</a>
                </li>
                @endcan
                @can("subcategory-list")
                <li class="nav-item flex-fill mx-2">
                    <a class="nav-link {{ request()->routeIs('subcategories.index') ? 'active' : '' }}" href="{{ route('subcategories.index') }}">Subcategorías</a>
                </li>
                @endcan
                <li class="nav-item dropdown flex-fill mx-2">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pedidos
                    </a>
                    <ul class="dropdown-menu">
                        @can("order-create")
                            <li><a class="dropdown-item" href="{{ route('orders.create') }}">Realizar Pedido</a></li>
                        @endcan
                            @can("order-list")
                        <li><a class="dropdown-item" href="{{ route('orders.index') }}">Ver mis pedidos</a></li>
                            @endcan
                    </ul>
                </li>
                @can("user-list")
                <li class="nav-item flex-fill mx-2">
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Usuarios</a>
                </li>
                @endcan
                @can("role-list")
                <li class="nav-item flex-fill mx-2">
                    <a class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">Roles</a>
                </li>
                @endcan
            </ul>

            <ul class="navbar-nav flex-column">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.show', Auth::user()->id) }}">{{ Auth::user()->name }}</a>                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link small">Cerrar sesión</button>
                        </form>
                    </li>
                @endguest
            </ul>
            @endauth
        </div>
    </div>
</nav>
