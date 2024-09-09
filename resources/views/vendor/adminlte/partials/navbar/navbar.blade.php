<nav
    class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- Language Dropdown --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" role="button">
                <i class="fas fa-globe"></i>
            </a>
            <div class="dropdown-menu" style="min-width: 2.5rem; top: 100%; left: 0; right: 0; margin: 0 auto;">
                <a href="{{ route('change-locale', ['locale' => 'en']) }}"
                    class="dropdown-item d-flex justify-content-center align-items-center p-2">
                    <img src="{{ asset('storage/flags/britain.png') }}" alt="English" class="flag-image me-2 w-50">
                </a>
                <a href="{{ route('change-locale', ['locale' => 'ka']) }}"
                    class="dropdown-item d-flex justify-content-center align-items-center p-2">
                    <img src="{{ asset('storage/flags/georgia.png') }}" alt="Georgian" class="flag-image me-2 w-50">
                </a>
            </div>
        </li>

        {{-- User menu link --}}
        @if (Auth::user())
            @if (config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif



        {{-- Right sidebar toggler link --}}
        @if (config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
