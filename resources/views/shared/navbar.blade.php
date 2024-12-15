<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Skup surowców</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link @if (str_contains(request()->path(), 'materials')) active @endif"
                        href="{{ route('materials.index') }}">Surowce</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (str_contains(request()->path(), 'materials')) active @endif"
                        href="{{ route('materials.offers') }}">Oferty</a>
                </li>
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.panel') }}">Panel Admina</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.show', Auth::user()) }}">Konto</a>
                    </li>
                @endif
                @if (Auth::check() && Auth::user()->role == 'user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.panel', Auth::user()->id) }}">Panel użytkownika</a>
                    </li>
                @endif
            </ul>
            <ul id="navbar-user" class="navbar-nav mb-2 mb-lg-0">
                <li class="pr-5">
                    <button class="nav-link" onclick="themeToggle()"> <i class="bi bi-yin-yang"></i></button>
                </li>
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Wyloguj się... </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Zaloguj się...</a>
                    </li>
                @endif
            </ul>
        </div>
        @include('shared.success-toast')
    </div>
</nav>
