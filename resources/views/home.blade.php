@extends('layouts.app')

@section('title', 'Início | Padaria')

@section('content')
    <section class="home-hero mx-auto grid w-full max-w-6xl grid-cols-1 items-center gap-8 px-6 py-10 sm:px-10 sm:py-14 lg:grid-cols-2 lg:gap-12">
        <div class="home-hero__copy">
            <p class="eyebrow eyebrow--light"><span class="eyebrow__rule"></span> SEU ESPAÇO</p>
            <h1>Um bom momento começa com uma <em>pausa.</em></h1>
            <p class="home-hero__intro">Que bom ter você por aqui, {{ auth()->user()->name }}. Este espaço é um convite para apreciar o simples e levar um pouco de aconchego para o seu dia.</p>
            <a class="button button--cream mt-7 inline-flex items-center gap-3" href="#sobre">
                Conheça este espaço
                <svg aria-hidden="true" viewBox="0 0 20 20" fill="none"><path d="M4 10h11m-4-4 4 4-4 4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg>
            </a>
        </div>

        <div class="home-art" aria-hidden="true">
            <div class="home-art__halo"></div>
            <span class="home-art__seal">COM CALMA</span>
            <svg class="bread-illustration bread-illustration--home" viewBox="0 0 420 330" fill="none">
                <ellipse cx="214" cy="278" rx="142" ry="22" fill="#3C2A21" fill-opacity=".16"/>
                <circle cx="210" cy="163" r="130" fill="#E8D5BC"/>
                <circle cx="210" cy="163" r="112" stroke="#C6A47F" stroke-dasharray="2 8" stroke-linecap="round" stroke-width="1.4"/>
                <path d="M91 194c0-54 40-94 117-94 66 0 121 35 121 94v13c0 18-14 32-32 32H123c-18 0-32-14-32-32v-13Z" fill="#C88950" stroke="#714A31" stroke-width="4"/>
                <path d="M137 145c-10 14-15 29-15 45M197 124c-8 17-11 34-9 52M257 132c-9 16-13 33-12 51" stroke="#F4D9B4" stroke-linecap="round" stroke-width="8"/>
                <path d="M80 222h264c-7 25-29 43-56 43H136c-27 0-49-18-56-43Z" fill="#F7F1E7" stroke="#714A31" stroke-width="4"/>
                <path d="M129 246c18 8 42 12 80 12 34 0 59-4 79-12" stroke="#D8C0A2" stroke-linecap="round" stroke-width="3"/>
                <path d="M79 112c-12-13-18-29-17-46 17 1 31 7 42 19m-16 7c-2-19 3-36 14-51 13 11 21 25 23 42m-10-1c8-16 21-28 38-34 5 16 4 32-4 47" stroke="#78836B" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
                <path d="M321 102c12-13 18-29 17-46-17 1-31 7-42 19m16 7c2-19-3-36-14-51-13 11-21 25-23 42m10-1c-8-16-21-28-38-34-5 16-4 32 4 47" stroke="#78836B" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            </svg>
            <p class="home-art__caption">um instante só seu</p>
        </div>
    </section>

    <section id="sobre" class="home-note mx-auto grid w-full max-w-6xl grid-cols-1 gap-5 px-6 py-12 sm:px-10 md:grid-cols-[1fr_auto] md:items-end md:py-16">
        <div>
            <p class="eyebrow"><span class="eyebrow__rule"></span> UM RESPIRO NO DIA A DIA</p>
            <h2>Pequenos rituais também fazem parte da <em>vida.</em></h2>
        </div>
        <p class="home-note__text">Uma pausa, um encontro, um instante para si. Que este espaço acompanhe seus momentos com leveza e acolhimento.</p>
    </section>
@endsection
