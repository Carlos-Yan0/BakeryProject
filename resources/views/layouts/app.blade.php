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

    <div class="site-shell">
        <header class="site-header">
            <div class="site-header__inner mx-auto flex w-full max-w-6xl items-center justify-between px-5 py-5 sm:px-8">
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

                <nav class="site-nav" aria-label="Navegação principal">
                    @auth
                        <a class="site-nav__link" href="{{ route('home') }}">Início</a>
                        <span class="site-nav__greeting">Olá, {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="site-nav__logout">
                            @csrf
                            <button class="button button--outline button--small" type="submit">Sair</button>
                        </form>
                    @else
                        <a class="site-nav__link" href="{{ route('login') }}">Entrar</a>
                        <a class="button button--solid button--small" href="{{ route('register') }}">Criar conta</a>
                    @endauth
                </nav>
            </div>
        </header>

        @if (session('success'))
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
</body>
</html>
