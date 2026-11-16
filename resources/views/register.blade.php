@extends('layouts.app')

@section('title', 'Criar conta | Padaria')

@section('content')
    <section class="auth-shell mx-auto w-full max-w-6xl px-5 py-8 sm:px-8 sm:py-12" aria-labelledby="register-title">
        <div class="auth-card auth-card--register grid grid-cols-1 overflow-hidden rounded-[2rem] shadow-xl md:grid-cols-2">
            <aside class="auth-story">
                <p class="eyebrow"><span class="eyebrow__rule"></span> BOAS-VINDAS</p>
                <h1>Seu próximo bom momento pode começar <em>aqui.</em></h1>
                <p class="auth-story__text">Crie sua conta para fazer parte deste espaço. É simples e leva só alguns instantes.</p>
                <div class="auth-art" aria-hidden="true">
                    <div class="auth-art__disc"></div>
                    <svg class="bread-illustration" viewBox="0 0 360 270" fill="none">
                        <ellipse cx="183" cy="226" rx="117" ry="16" fill="#644733" fill-opacity=".14"/>
                        <circle cx="180" cy="136" r="99" fill="#E7D6C0"/>
                        <path d="M83 153c0-42 33-74 96-74 55 0 99 28 99 74v14c0 15-12 27-27 27H110c-15 0-27-12-27-27v-14Z" fill="#C88950" stroke="#714A31" stroke-width="4"/>
                        <path d="M125 117c-8 12-12 24-12 37m64-54c-7 14-9 28-8 43m49-37c-7 13-10 27-9 41" stroke="#F4D9B4" stroke-linecap="round" stroke-width="7"/>
                        <path d="M70 190h221c-6 22-25 37-48 37h-125c-23 0-42-15-48-37Z" fill="#FBF8F1" stroke="#714A31" stroke-width="4"/>
                        <path d="M108 211c18 6 42 9 74 9s56-3 74-9" stroke="#D8C0A2" stroke-linecap="round" stroke-width="3"/>
                    </svg>
                </div>
                <p class="auth-story__note"><span aria-hidden="true">✳</span> Um pouco de aconchego faz bem.</p>
            </aside>

            <div class="auth-form-panel">
                <div class="auth-heading">
                    <p class="eyebrow eyebrow--small">NOVA CONTA</p>
                    <h2 id="register-title">Crie sua conta</h2>
                    <p>Preencha seus dados para começar.</p>
                </div>

                @if ($errors->any())
                    <div class="form-alert" role="alert">Não foi possível continuar. Revise os campos indicados.</div>
                @endif

                <form action="{{ route('user.store') }}" method="POST" class="auth-form">
                    @csrf

                    <div class="form-field">
                        <label for="name">Nome</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            minlength="3"
                            maxlength="100"
                            autocomplete="name"
                            placeholder="Como podemos chamar você?"
                            required
                            aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                            @if ($errors->has('name')) aria-describedby="register-name-error" @endif
                        >
                        @error('name')
                            <p class="field-error" id="register-name-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="email">E-mail</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            maxlength="100"
                            autocomplete="email"
                            placeholder="voce@exemplo.com"
                            required
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                            @if ($errors->has('email')) aria-describedby="register-email-error" @endif
                        >
                        @error('email')
                            <p class="field-error" id="register-email-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="password">Senha</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            minlength="6"
                            maxlength="100"
                            autocomplete="new-password"
                            placeholder="Crie uma senha"
                            required
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                            aria-describedby="register-password-hint{{ $errors->has('password') ? ' register-password-error' : '' }}"
                        >
                        <span class="field-hint" id="register-password-hint">Use entre 6 e 100 caracteres.</span>
                        @error('password')
                            <p class="field-error" id="register-password-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="button button--solid button--submit" type="submit">
                        Criar conta
                        <svg aria-hidden="true" viewBox="0 0 20 20" fill="none"><path d="M4 10h11m-4-4 4 4-4 4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg>
                    </button>
                </form>

                <p class="auth-switch">Já tem uma conta? <a href="{{ route('login') }}">Entre por aqui</a></p>
            </div>
        </div>
    </section>
@endsection
