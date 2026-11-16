<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f7f1e7">
    <title>Categorias | Padaria</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f7f1e7] text-[#38291f] antialiased">
    @php
        $categoryDataAvailable = isset($categories) && $categories instanceof \Illuminate\Support\Collection;
        $categoryRows = $categoryDataAvailable ? $categories : collect();
        $successMessage = match (session('success')) {
            'category successfully created!', 'category successfully updated!' => 'Categoria salva com sucesso.',
            'category successfully deleted!' => 'Categoria excluída com sucesso.',
            default => session('success'),
        };
    @endphp

    <a href="#main-content" class="skip-link">Pular para o conteúdo</a>
    <header class="border-b border-[#e8ddce] bg-[#fffdf9]">
        <div class="mx-auto flex min-h-[76px] w-full max-w-7xl items-center justify-between gap-4 px-5 sm:px-8">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-3 rounded-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#98633e]" aria-label="Voltar ao catálogo">
                <span class="grid size-11 place-items-center rounded-2xl bg-[#563d2e] text-[#f7f1e7]" aria-hidden="true"><svg viewBox="0 0 48 48" fill="none" class="size-8"><path d="M9 25.5c0-8.3 6.7-15 15-15s15 6.7 15 15v9.2c0 1.8-1.5 3.3-3.3 3.3H12.3A3.3 3.3 0 0 1 9 34.7v-9.2Z" fill="currentColor"/><path d="M18 19.5c-1.5 2.1-2.2 4.3-2.2 6.8M25.2 16.8c-1.1 2.3-1.6 4.7-1.4 7.2M32.1 19.5c-1.2 2.1-1.7 4.3-1.5 6.7" stroke="#F7F1E7" stroke-linecap="round" stroke-width="2.2"/></svg></span>
                <span><span class="block font-serif text-xl font-semibold tracking-tight">Padaria</span><span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[.18em] text-[#897765]">Gestão do catálogo</span></span>
            </a>
            <nav class="flex items-center gap-1 rounded-full border border-[#e8ddce] bg-[#f8f3eb] p-1 text-xs font-semibold" aria-label="Navegação do catálogo">
                <a href="{{ route('products.index') }}" class="rounded-full px-3 py-2 text-[#715d4b] transition hover:bg-white hover:text-[#38291f]">Produtos</a>
                <a href="{{ route('categories.index') }}" aria-current="page" class="rounded-full bg-[#563d2e] px-3 py-2 text-white">Categorias</a>
            </nav>
        </div>
    </header>

    <main id="main-content" class="mx-auto w-full max-w-7xl px-5 pb-12 pt-8 sm:px-8 sm:pt-11">
        <section class="mb-8 flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
            <div><p class="mb-3 flex items-center gap-2 text-xs font-bold uppercase tracking-[.18em] text-[#8b725c]"><span class="h-px w-7 bg-[#b98457]" aria-hidden="true"></span>Catálogo</p><h1 class="font-serif text-4xl font-medium tracking-tight sm:text-5xl">Categorias</h1><p class="mt-3 max-w-xl text-sm leading-6 text-[#786858] sm:text-base">Organize os grupos usados para classificar os produtos.</p></div>
            <button type="button" data-open-category-modal aria-haspopup="dialog" aria-controls="category-dialog" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-[#563d2e] px-5 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#412d21] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-3 focus-visible:outline-[#98633e]"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-5"><path d="M10 4v12M4 10h12" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/></svg>Nova categoria</button>
        </section>

        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#d5e1cf] bg-[#f2f7ef] px-4 py-3.5 text-sm text-[#405b3a]" role="status" aria-live="polite" data-category-success><span class="grid size-6 shrink-0 place-items-center rounded-full bg-[#dfebd9] font-bold" aria-hidden="true">✓</span><p class="pt-0.5">{{ $successMessage }}</p></div>
        @endif

        @if (!$categoryDataAvailable)
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#ead8b8] bg-[#fff9ec] px-4 py-4 text-sm leading-6 text-[#725a35]" role="alert">
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="mt-0.5 size-5 shrink-0"><path d="M10 6.5v4m0 3h.01M10 2.8l7.4 13a.9.9 0 0 1-.8 1.3H3.4a.9.9 0 0 1-.8-1.3l7.4-13a1.1 1.1 0 0 1 2 0Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                <p>Não foi possível carregar as categorias. A rota atual não está entregando a lista para esta view; o formulário de cadastro continua disponível.</p>
            </div>
        @endif

        <section class="mb-7 grid grid-cols-1 gap-3 sm:grid-cols-2" aria-label="Resumo das categorias">
            <article class="rounded-2xl border border-[#e8ddce] bg-[#fffdf9] px-5 py-4 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[.12em] text-[#897765]">Categorias carregadas</p><p class="mt-2 font-serif text-3xl">{{ $categoryRows->count() }}</p></article>
            <article class="rounded-2xl border border-[#e8ddce] bg-[#fffdf9] px-5 py-4 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[.12em] text-[#897765]">Uso no catálogo</p><p class="mt-2 text-sm font-semibold text-[#70543c]">Agrupa produtos por categoria</p></article>
        </section>

        <section class="overflow-hidden rounded-[1.6rem] border border-[#e8ddce] bg-[#fffdf9] shadow-[0_16px_50px_rgba(74,52,35,.055)]" aria-labelledby="category-list-title">
            <div class="flex flex-col gap-4 border-b border-[#eee5d9] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                <div><h2 id="category-list-title" class="font-serif text-2xl">Lista de categorias</h2><p class="mt-1 text-sm text-[#897765]">{{ $categoryRows->count() }} {{ $categoryRows->count() === 1 ? 'categoria' : 'categorias' }}</p></div>
                <label class="relative block sm:min-w-64"><span class="sr-only">Buscar categoria</span><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-[#95816c]"><circle cx="8.8" cy="8.8" r="5.8" stroke="currentColor" stroke-width="1.5"/><path d="m13.2 13.2 4 4" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"/></svg><input id="category-search" type="search" placeholder="Buscar categoria..." class="min-h-11 w-full rounded-xl border border-[#e4d9ca] bg-[#fffefa] pl-10 pr-3 text-sm placeholder:text-[#a39484] focus:border-[#a8754f] focus:outline-none focus:ring-2 focus:ring-[#a8754f]/15"></label>
            </div>
            <p id="category-filter-status" class="sr-only" role="status" aria-live="polite"></p>
            <div class="table-scroll" tabindex="0" role="region" aria-label="Tabela de categorias; deslize horizontalmente em telas pequenas">
                <table class="w-full min-w-[560px] border-collapse text-left">
                    <thead class="bg-[#faf6ef] text-[11px] font-bold uppercase tracking-[.12em] text-[#897765]"><tr><th scope="col" class="px-7 py-3.5">Categoria</th><th scope="col" class="px-4 py-3.5">Identificador</th><th scope="col" class="px-7 py-3.5 text-right">Ações</th></tr></thead>
                    <tbody class="divide-y divide-[#f0e8de]">
                        @forelse ($categoryRows as $category)
                            <tr class="category-row transition-colors hover:bg-[#fcf9f4]" data-category-row data-search="{{ mb_strtolower($category->category_name, 'UTF-8') }}"><td class="px-7 py-4 text-sm font-semibold text-[#443326]">{{ $category->category_name }}</td><td class="px-4 py-4 font-mono text-xs text-[#94816d]">#{{ $category->id }}</td><td class="px-7 py-3 text-right"><div class="flex items-center justify-end gap-1"><button type="button" class="inline-flex min-h-9 items-center gap-1.5 rounded-lg px-2.5 text-xs font-semibold text-[#70543c] transition hover:bg-[#f3e9dc] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-edit-category data-category-id="{{ $category->id }}" data-category-name="{{ $category->category_name }}" aria-label="Editar categoria {{ $category->category_name }}" aria-haspopup="dialog" aria-controls="category-dialog"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-4"><path d="m12.8 3.7 3.5 3.5M4 16l3.3-.7 8.5-8.5a1.8 1.8 0 0 0-2.6-2.6l-8.5 8.5L4 16Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"/></svg>Editar</button><button type="button" class="grid size-9 place-items-center rounded-lg text-[#947967] transition hover:bg-[#fbefea] hover:text-[#a04b3b] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-delete-category data-category-id="{{ $category->id }}" data-category-name="{{ $category->category_name }}" aria-label="Excluir categoria {{ $category->category_name }}" aria-haspopup="dialog" aria-controls="delete-category-dialog"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-[18px]"><path d="M4.5 6h11m-9.7 0 .6 10h7.2l.6-10M8 6V4h4v2m-3 3v4m2-4v4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"/></svg></button></div></td></tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-14 text-center"><span class="mx-auto grid size-12 place-items-center rounded-2xl bg-[#f3e7d6] text-[#8a603e]" aria-hidden="true"><svg viewBox="0 0 20 20" fill="none" class="size-6"><path d="M3 5.5h14v10H3zM3 8h14M6 3.5v2m8-2v2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"/></svg></span><h3 class="mt-4 font-serif text-xl text-[#443326]">Nenhuma categoria disponível</h3><p class="mt-1 text-sm text-[#897765]">Cadastre uma categoria para usá-la nos produtos.</p></td></tr>
                        @endforelse
                        @if ($categoryRows->isNotEmpty())<tr id="no-category-results" hidden><td colspan="3" class="px-6 py-10 text-center text-sm text-[#897765]">Nenhuma categoria corresponde à busca.</td></tr>@endif
                    </tbody>
                </table>
            </div>
        </section>

        <p class="mt-5 text-center text-xs text-[#978775]">As categorias disponíveis aqui são as recebidas pela listagem.</p>
    </main>

    <dialog id="category-dialog" class="app-dialog app-dialog--compact" aria-labelledby="category-dialog-title" data-has-errors="{{ $errors->any() ? 'true' : 'false' }}">
        <div class="flex max-h-[90dvh] flex-col">
            <div class="flex items-start justify-between gap-4 border-b border-[#eee5d9] px-6 py-5 sm:px-8"><div><p class="text-[11px] font-bold uppercase tracking-[.16em] text-[#9a704e]">CATÁLOGO</p><h2 id="category-dialog-title" class="mt-1 font-serif text-2xl">Nova categoria</h2><p class="mt-1 text-sm text-[#897765]" data-category-dialog-description>Dê um nome claro para o grupo.</p></div><button type="button" class="grid size-9 shrink-0 place-items-center rounded-full text-[#806e5e] hover:bg-[#f4eee5] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-close-dialog aria-label="Fechar janela"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-5"><path d="m5 5 10 10M15 5 5 15" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg></button></div>
            <form id="category-form" action="{{ route('categories.store') }}" method="POST" class="px-6 py-6 sm:px-8" data-store-url="{{ route('categories.store') }}" data-update-url-template="{{ route('categories.update', ['id' => '__CATEGORY_ID__']) }}" data-has-errors="{{ $errors->any() ? 'true' : 'false' }}">
                @csrf
                @method('PUT')
                @if ($errors->any())<div class="mb-5 rounded-xl border border-[#ead1c5] bg-[#fcf2ed] px-4 py-3 text-sm text-[#864c36]" role="alert" data-category-validation-summary>Revise o campo destacado e tente novamente.</div>@endif
                <div class="form-field"><label for="category-name" class="form-label">Nome da categoria <span aria-hidden="true">*</span></label><input id="category-name" name="category_name" type="text" value="{{ old('category_name') }}" minlength="3" maxlength="100" required autocomplete="off" placeholder="Nome da categoria" class="form-input" aria-invalid="{{ $errors->has('category_name') ? 'true' : 'false' }}" @if ($errors->has('category_name')) aria-describedby="category-name-error" @endif>@error('category_name')<p id="category-name-error" class="form-error" data-category-field-error>{{ $message }}</p>@enderror<p class="text-xs leading-5 text-[#897765]">Use entre 3 e 100 caracteres.</p></div>
                <div class="mt-7 flex flex-col-reverse gap-2 border-t border-[#eee5d9] pt-5 sm:flex-row sm:justify-end"><button type="button" class="inline-flex min-h-11 items-center justify-center rounded-full border border-[#dfd2c1] px-5 text-sm font-semibold text-[#665545] hover:bg-[#f8f3eb] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-close-dialog>Cancelar</button><button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-full bg-[#563d2e] px-5 text-sm font-semibold text-white hover:bg-[#412d21] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]"><span data-category-submit-label>Cadastrar categoria</span><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-4"><path d="M4 10h11m-4-4 4 4-4 4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"/></svg></button></div>
            </form>
        </div>
    </dialog>

    <dialog id="delete-category-dialog" class="app-dialog app-dialog--compact" aria-labelledby="delete-category-dialog-title">
        <div class="p-6 sm:p-8">
            <div class="flex items-start gap-4">
                <span class="grid size-11 shrink-0 place-items-center rounded-2xl bg-[#fbefea] text-[#a04b3b]" aria-hidden="true"><svg viewBox="0 0 20 20" fill="none" class="size-5"><path d="M4.5 6h11m-9.7 0 .6 10h7.2l.6-10M8 6V4h4v2m-3 3v4m2-4v4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"/></svg></span>
                <div><h2 id="delete-category-dialog-title" class="font-serif text-2xl">Excluir categoria?</h2><p class="mt-2 text-sm leading-6 text-[#786858]">Esta ação removerá <strong class="font-semibold text-[#574536]" data-delete-category-name>esta categoria</strong>.</p><p class="mt-2 text-xs leading-5 text-[#897765]">Se houver produtos vinculados, o banco pode impedir a exclusão.</p></div>
            </div>
            <form id="delete-category-form" action="#" method="POST" class="mt-7 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end" data-delete-url-template="{{ route('categories.delete', ['id' => '__CATEGORY_ID__']) }}">
                @csrf
                @method('DELETE')
                <button type="button" class="inline-flex min-h-11 items-center justify-center rounded-full border border-[#dfd2c1] px-5 text-sm font-semibold text-[#665545] hover:bg-[#f8f3eb] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-close-dialog>Cancelar</button>
                <button type="submit" disabled class="inline-flex min-h-11 items-center justify-center rounded-full bg-[#9b4c3d] px-5 text-sm font-semibold text-white hover:bg-[#843a2e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#843a2e] disabled:cursor-not-allowed disabled:opacity-50">Excluir categoria</button>
            </form>
        </div>
    </dialog>
</body>
</html>
