<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('welcome') }}"><img
                src="http://skytel-front.test/vendor/adminlte/dist/img/AdminLTELogo.png" alt="Admin Logo"
                class="brand-image img-circle elevation-3" style="width: 60px; height: auto;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto justify-content-lg-center w-100">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}"
                        href="{{ route('welcome') }}">
                        Home
                        @if (request()->routeIs('welcome'))
                            <span class="visually-hidden">(current)</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('features') ? 'active' : '' }}"
                        href="{{ route('features') }}">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}"
                        href="{{ route('news.index') }}">News</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('plans.*') ? 'active' : '' }}"
                        href="{{ route('plans.index') }}">Plans</a>
                </li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="languageDropdown"
                        style="min-width: 80px;">
                        <li>
                            <a href="{{ route('change-locale', ['locale' => 'ka']) }}"
                                class="dropdown-item text-center p-2">
                                <img src="{{ asset('storage/flags/georgia.png') }}" alt="Georgian"
                                    class="flag-image w-25">
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('change-locale', ['locale' => 'en']) }}"
                                class="dropdown-item text-center p-2">
                                <img src="{{ asset('storage/flags/britain.png') }}" alt="English"
                                    class="flag-image w-25">
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
