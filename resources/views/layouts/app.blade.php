<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f7f1e7">
    <title>@yield('title', 'Padaria')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f7f1e7] text-[#3b2a20] antialiased">
    <a class="skip-link" href="#main-content">Pular para o conteúdo</a>

    <div class="site-shell site-shell--sidebar">
        <aside class="app-sidebar" aria-label="Menu da Padaria">
            <a class="brand" href="{{ auth()->check() ? route('home') : route('login') }}" aria-label="Padaria, início">
                <span class="brand__mark" aria-hidden="true">
                    <svg viewBox="0 0 48 48" fill="none">
                        <path d="M9 25.5c0-8.3 6.7-15 15-15s15 6.7 15 15v9.2c0 1.8-1.5 3.3-3.3 3.3H12.3A3.3 3.3 0 0 1 9 34.7v-9.2Z" fill="currentColor"/>
                        <path d="M18 19.5c-1.5 2.1-2.2 4.3-2.2 6.8M25.2 16.8c-1.1 2.3-1.6 4.7-1.4 7.2M32.1 19.5c-1.2 2.1-1.7 4.3-1.5 6.7" stroke="#F7F1E7" stroke-linecap="round" stroke-width="2.2"/>
                    </svg>
                </span>
                <span class="brand__copy">
                    <span class="brand__name">Padaria</span>
                    <span class="brand__tagline">um lugar para pausar</span>
                </span>
            </a>

            <nav class="app-sidebar__nav" aria-label="Navegação principal">
                @auth
                    <a class="app-sidebar__link {{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Início</a>
                    <div class="app-sidebar__catalog">
                        <p>Catálogo</p>
                        <div class="catalog-switch" role="group" aria-label="Alternar entre produtos e categorias">
                            <a class="catalog-switch__link {{ request()->routeIs('products.index') ? 'is-active' : '' }}" href="{{ route('products.index') }}" @if (request()->routeIs('products.index')) aria-current="page" @endif>Produtos</a>
                            <a class="catalog-switch__link {{ request()->routeIs('categories.index') ? 'is-active' : '' }}" href="{{ route('categories.index') }}" @if (request()->routeIs('categories.index')) aria-current="page" @endif>Categorias</a>
                        </div>
                    </div>
                @else
                    <a class="app-sidebar__link {{ request()->routeIs('login') ? 'is-active' : '' }}" href="{{ route('login') }}" @if (request()->routeIs('login')) aria-current="page" @endif>Entrar</a>
                    <a class="app-sidebar__link {{ request()->routeIs('register') ? 'is-active' : '' }}" href="{{ route('register') }}" @if (request()->routeIs('register')) aria-current="page" @endif>Criar conta</a>
                @endauth
            </nav>

            @auth
                <div class="app-sidebar__account">
                    <p>Olá, {{ auth()->user()->name }}</p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="button button--outline" type="submit">Sair</button>
                    </form>
                </div>
            @endauth
        </aside>

        <button class="mobile-menu-toggle" type="button" aria-label="Abrir navegação" aria-controls="mobile-sidebar" aria-expanded="false" data-open-mobile-sidebar>
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/></svg>
        </button>

        <dialog id="mobile-sidebar" class="mobile-sidebar" aria-labelledby="mobile-sidebar-title">
            <div class="mobile-sidebar__panel">
                <div class="mobile-sidebar__heading">
                    <div>
                        <p class="eyebrow eyebrow--small">PADARIA</p>
                        <h2 id="mobile-sidebar-title">Navegação</h2>
                    </div>
                    <button class="mobile-sidebar__close" type="button" data-close-dialog aria-label="Fechar navegação">
                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m5 5 10 10M15 5 5 15" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                    </button>
                </div>

                <nav class="mobile-sidebar__nav" aria-label="Navegação principal">
                    @auth
                        <a class="mobile-sidebar__link {{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Início</a>
                        <div class="mobile-sidebar__catalog">
                            <p>Catálogo</p>
                            <div class="catalog-switch catalog-switch--mobile" role="group" aria-label="Alternar entre produtos e categorias">
                                <a class="catalog-switch__link {{ request()->routeIs('products.index') ? 'is-active' : '' }}" href="{{ route('products.index') }}" @if (request()->routeIs('products.index')) aria-current="page" @endif>Produtos</a>
                                <a class="catalog-switch__link {{ request()->routeIs('categories.index') ? 'is-active' : '' }}" href="{{ route('categories.index') }}" @if (request()->routeIs('categories.index')) aria-current="page" @endif>Categorias</a>
                            </div>
                        </div>
                        <p class="mobile-sidebar__greeting">Olá, {{ auth()->user()->name }}</p>
                        <form action="{{ route('logout') }}" method="POST" class="mobile-sidebar__logout">
                            @csrf
                            <button class="button button--outline" type="submit">Sair</button>
                        </form>
                    @else
                        <a class="mobile-sidebar__link {{ request()->routeIs('login') ? 'is-active' : '' }}" href="{{ route('login') }}" @if (request()->routeIs('login')) aria-current="page" @endif>Entrar</a>
                        <a class="mobile-sidebar__link {{ request()->routeIs('register') ? 'is-active' : '' }}" href="{{ route('register') }}" @if (request()->routeIs('register')) aria-current="page" @endif>Criar conta</a>
                    @endauth
                </nav>
            </div>
        </dialog>

        <div class="site-page">
            @if (session('success') && !request()->routeIs('products.index', 'categories.index'))
                <div class="flash-message mx-auto mt-5 w-[calc(100%-2.5rem)] max-w-6xl" role="status" aria-live="polite">
                    <span class="flash-message__icon" aria-hidden="true">✓</span>
                    <p>
                        @if (session('success') === 'User created succesfully')
                            Sua conta foi criada. Entre para continuar.
                        @elseif (session('success') === 'Login successfully')
                            Login realizado com sucesso. Que bom ter você por aqui.
                        @else
                            {{ session('success') }}
                        @endif
                    </p>
                </div>
            @endif

            <main id="main-content" class="site-main">
                @yield('content')
            </main>

            <footer class="site-footer mx-auto flex w-full max-w-6xl flex-col items-center justify-between gap-2 px-5 py-7 sm:flex-row sm:px-8">
                <a class="site-footer__brand" href="{{ auth()->check() ? route('home') : route('login') }}">Padaria</a>
                <p>Um convite para apreciar os momentos simples.</p>
            </footer>
        </div>
    </div>
</body>
</html>
