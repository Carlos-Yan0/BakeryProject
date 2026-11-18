@extends('layouts.app')

@section('title', 'Produtos | Padaria')

@section('content')
    @php
        $categoryById = $categories->keyBy('id');
        $activeProductCount = $products->filter(fn ($product) => (bool) $product->active)->count();
        $successMessage = match (session('success')) {
            'product created successfully' => 'Produto criado com sucesso.',
            'product successfully updated!' => 'Produto atualizado com sucesso.',
            'Product successfully deleted!' => 'Produto excluído com sucesso.',
            default => session('success'),
        };
    @endphp

    <div class="mx-auto w-full max-w-7xl px-5 pb-12 pt-8 sm:px-8 sm:pt-11">
        <section class="mb-8 flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
            <div>
                <p class="mb-3 flex items-center gap-2 text-xs font-bold uppercase tracking-[.18em] text-[#8b725c]"><span class="h-px w-7 bg-[#b98457]" aria-hidden="true"></span>Catálogo</p>
                <h1 class="font-serif text-4xl font-medium tracking-tight sm:text-5xl">Produtos</h1>
                <p class="mt-3 max-w-xl text-sm leading-6 text-[#786858] sm:text-base">Acompanhe e organize os produtos cadastrados.</p>
            </div>
            <button type="button" data-open-product-modal="create" aria-haspopup="dialog" aria-controls="product-dialog" @disabled($categories->isEmpty()) class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-[#563d2e] px-5 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#412d21] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-3 focus-visible:outline-[#98633e] disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:translate-y-0">
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-5"><path d="M10 4v12M4 10h12" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/></svg>
                Novo produto
            </button>
        </section>

        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#d5e1cf] bg-[#f2f7ef] px-4 py-3.5 text-sm text-[#405b3a]" role="status" aria-live="polite" data-success-notice>
                <span class="grid size-6 shrink-0 place-items-center rounded-full bg-[#dfebd9] font-bold" aria-hidden="true">✓</span><p class="pt-0.5">{{ $successMessage }}</p>
            </div>
        @endif

        @if ($categories->isEmpty())
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-[#ead8b8] bg-[#fff9ec] px-4 py-4 text-sm text-[#725a35]" role="status">
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="mt-0.5 size-5 shrink-0"><path d="M10 6.5v4m0 3h.01M10 2.8l7.4 13a.9.9 0 0 1-.8 1.3H3.4a.9.9 0 0 1-.8-1.3l7.4-13a1.1 1.1 0 0 1 2 0Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                <p>Nenhuma categoria está cadastrada. O backend exige uma categoria existente para criar ou atualizar produtos.</p>
            </div>
        @endif

        <section class="mb-7 grid grid-cols-1 gap-3 sm:grid-cols-3" aria-label="Resumo do catálogo">
            <article class="rounded-2xl border border-[#e8ddce] bg-[#fffdf9] px-5 py-4 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[.12em] text-[#897765]">Produtos cadastrados</p><p class="mt-2 font-serif text-3xl">{{ $products->count() }}</p></article>
            <article class="rounded-2xl border border-[#e8ddce] bg-[#fffdf9] px-5 py-4 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[.12em] text-[#897765]">Produtos ativos</p><p class="mt-2 font-serif text-3xl text-[#52654a]">{{ $activeProductCount }}</p></article>
            <article class="rounded-2xl border border-[#e8ddce] bg-[#fffdf9] px-5 py-4 shadow-sm"><p class="text-xs font-semibold uppercase tracking-[.12em] text-[#897765]">Categorias disponíveis</p><p class="mt-2 font-serif text-3xl text-[#8a603e]">{{ $categories->count() }}</p></article>
        </section>

        <section class="overflow-hidden rounded-[1.6rem] border border-[#e8ddce] bg-[#fffdf9] shadow-[0_16px_50px_rgba(74,52,35,.055)]" aria-labelledby="product-list-title">
            <div class="flex flex-col gap-4 border-b border-[#eee5d9] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                <div><h2 id="product-list-title" class="font-serif text-2xl">Lista de produtos</h2><p class="mt-1 text-sm text-[#897765]">{{ $products->count() }} {{ $products->count() === 1 ? 'item' : 'itens' }} no catálogo</p></div>
                <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                    <label class="relative block sm:min-w-64">
                        <span class="sr-only">Buscar por nome ou código</span>
                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-[#95816c]"><circle cx="8.8" cy="8.8" r="5.8" stroke="currentColor" stroke-width="1.5"/><path d="m13.2 13.2 4 4" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"/></svg>
                        <input id="product-search" type="search" placeholder="Buscar produto..." class="min-h-11 w-full rounded-xl border border-[#e4d9ca] bg-[#fffefa] pl-10 pr-3 text-sm placeholder:text-[#a39484] focus:border-[#a8754f] focus:outline-none focus:ring-2 focus:ring-[#a8754f]/15">
                    </label>
                    <label><span class="sr-only">Filtrar por situação</span><select id="product-status-filter" class="min-h-11 w-full rounded-xl border border-[#e4d9ca] bg-[#fffefa] px-3 text-sm text-[#574536] focus:border-[#a8754f] focus:outline-none focus:ring-2 focus:ring-[#a8754f]/15 sm:w-40"><option value="all">Todas as situações</option><option value="1">Ativos</option><option value="0">Inativos</option></select></label>
                </div>
                <p id="product-filter-status" class="sr-only" role="status" aria-live="polite"></p>
            </div>

            <div class="table-scroll" tabindex="0" role="region" aria-label="Tabela de produtos; deslize horizontalmente em telas pequenas">
                <table class="w-full min-w-[850px] border-collapse text-left">
                    <thead class="bg-[#faf6ef] text-[11px] font-bold uppercase tracking-[.12em] text-[#897765]"><tr><th scope="col" class="px-7 py-3.5">Produto</th><th scope="col" class="px-4 py-3.5">Categoria</th><th scope="col" class="px-4 py-3.5">Estoque</th><th scope="col" class="px-4 py-3.5">Preço</th><th scope="col" class="px-4 py-3.5">Situação</th><th scope="col" class="px-7 py-3.5 text-right">Ações</th></tr></thead>
                    <tbody class="divide-y divide-[#f0e8de]">
                        @forelse ($products as $product)
                            @php($productCategory = $categoryById->get($product->category_id))
                            <tr class="product-row transition-colors hover:bg-[#fcf9f4]" data-product-row data-search="{{ mb_strtolower($product->product_code . ' ' . $product->name, 'UTF-8') }}" data-active="{{ $product->active ? '1' : '0' }}">
                                <td class="px-7 py-4"><div class="flex min-w-56 items-center gap-3"><span class="grid size-10 shrink-0 place-items-center rounded-xl bg-[#f3e7d6] text-[#8a603e]" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" class="size-5"><path d="M4 10.5c0-4.1 3.3-7.5 7.5-7.5S19 6.4 19 10.5v5.3a2.2 2.2 0 0 1-2.2 2.2H6.2A2.2 2.2 0 0 1 4 15.8v-5.3Z" stroke="currentColor" stroke-width="1.6"/><path d="M8 8.5c-.7 1-.9 2-.8 3m4-4.7c-.5 1.1-.6 2.2-.5 3.3m4-2.8c-.4.9-.6 1.9-.5 2.9" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"/></svg></span><span class="min-w-0"><span class="block max-w-64 truncate text-sm font-semibold text-[#443326]">{{ $product->name }}</span><span class="mt-1 block font-mono text-xs text-[#94816d]">{{ $product->product_code }}</span></span></div></td>
                                <td class="px-4 py-4 text-sm text-[#715f4d]">{{ data_get($productCategory, 'category_name', '—') }}</td>
                                <td class="px-4 py-4 text-sm font-medium tabular-nums text-[#574536]">{{ $product->stock }}</td>
                                <td class="px-4 py-4 text-sm font-semibold tabular-nums text-[#443326]">R$ {{ number_format((float) $product->price, 2, ',', '.') }}</td>
                                <td class="px-4 py-4">@if ($product->active)<span class="inline-flex items-center gap-1.5 rounded-full bg-[#edf3e9] px-2.5 py-1 text-xs font-semibold text-[#4d6945]"><span class="size-1.5 rounded-full bg-[#718965]" aria-hidden="true"></span>Ativo</span>@else<span class="inline-flex items-center gap-1.5 rounded-full bg-[#f1eee9] px-2.5 py-1 text-xs font-semibold text-[#796d60]"><span class="size-1.5 rounded-full bg-[#9d9183]" aria-hidden="true"></span>Inativo</span>@endif</td>
                                <td class="px-7 py-4"><div class="flex items-center justify-end gap-1.5">
                                    <button type="button" class="inline-flex min-h-9 items-center gap-1.5 rounded-lg px-2.5 text-xs font-semibold text-[#70543c] transition hover:bg-[#f3e9dc] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-edit-product data-product-id="{{ $product->id }}" data-product-code="{{ $product->product_code }}" data-product-name="{{ $product->name }}" data-product-description="{{ $product->description }}" data-product-stock="{{ $product->stock }}" data-product-price="{{ $product->price }}" data-product-category="{{ $product->category_id }}" data-product-active="{{ $product->active ? '1' : '0' }}" aria-label="Editar {{ $product->name }}" aria-haspopup="dialog" aria-controls="product-dialog"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-4"><path d="m12.8 3.7 3.5 3.5M4 16l3.3-.7 8.5-8.5a1.8 1.8 0 0 0-2.6-2.6l-8.5 8.5L4 16Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"/></svg>Editar</button>
                                    <button type="button" class="grid size-9 place-items-center rounded-lg text-[#947967] transition hover:bg-[#fbefea] hover:text-[#a04b3b] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-delete-product data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" aria-label="Excluir {{ $product->name }}" aria-haspopup="dialog" aria-controls="delete-dialog"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-[18px]"><path d="M4.5 6h11m-9.7 0 .6 10h7.2l.6-10M8 6V4h4v2m-3 3v4m2-4v4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"/></svg></button>
                                </div></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-16 text-center"><span class="mx-auto grid size-14 place-items-center rounded-2xl bg-[#f3e7d6] text-[#8a603e]" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" class="size-7"><path d="M4 10.5c0-4.1 3.3-7.5 7.5-7.5S19 6.4 19 10.5v5.3a2.2 2.2 0 0 1-2.2 2.2H6.2A2.2 2.2 0 0 1 4 15.8v-5.3Z" stroke="currentColor" stroke-width="1.6"/><path d="M8 8.5c-.7 1-.9 2-.8 3m4-4.7c-.5 1.1-.6 2.2-.5 3.3m4-2.8c-.4.9-.6 1.9-.5 2.9" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"/></svg></span><h3 class="mt-4 font-serif text-xl text-[#443326]">Nenhum produto cadastrado</h3><p class="mt-1 text-sm text-[#897765]">Quando houver produtos, eles aparecerão nesta lista.</p></td></tr>
                        @endforelse
                        @if ($products->isNotEmpty())<tr id="no-filter-results" hidden><td colspan="6" class="px-6 py-12 text-center text-sm text-[#897765]">Nenhum produto corresponde a essa busca.</td></tr>@endif
                    </tbody>
                </table>
            </div>
        </section>
        <p class="mt-5 text-center text-xs text-[#978775]">Os dados e as ações desta tela usam o catálogo já cadastrado.</p>
    </div>

    <dialog id="product-dialog" class="app-dialog" aria-labelledby="product-dialog-title" data-has-errors="{{ $errors->any() ? 'true' : 'false' }}">
        <div class="flex max-h-[90dvh] flex-col">
            <div class="flex items-start justify-between gap-4 border-b border-[#eee5d9] px-6 py-5 sm:px-8"><div><p class="text-[11px] font-bold uppercase tracking-[.16em] text-[#9a704e]">CATÁLOGO</p><h2 id="product-dialog-title" class="mt-1 font-serif text-2xl">Novo produto</h2><p class="mt-1 text-sm text-[#897765]" data-dialog-description>Preencha os dados do produto.</p></div><button type="button" class="grid size-9 shrink-0 place-items-center rounded-full text-[#806e5e] hover:bg-[#f4eee5] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-close-dialog aria-label="Fechar janela"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-5"><path d="m5 5 10 10M15 5 5 15" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg></button></div>
            <form id="product-form" action="{{ route('products.store') }}" method="POST" class="min-h-0 overflow-y-auto px-6 py-6 sm:px-8" data-store-url="{{ route('products.store') }}" data-update-url-template="{{ route('products.update', ['id' => '__PRODUCT_ID__']) }}">
                @csrf
                @method('PUT')
                @if ($errors->any())<div class="mb-5 rounded-xl border border-[#ead1c5] bg-[#fcf2ed] px-4 py-3 text-sm text-[#864c36]" role="alert" data-validation-summary>Revise os campos destacados e tente novamente.</div>@endif
                <div class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                    <div class="form-field"><label for="product-code" class="form-label">Código do produto <span aria-hidden="true">*</span></label><input id="product-code" name="product_code" type="text" value="{{ old('product_code') }}" minlength="3" maxlength="100" required autocomplete="off" placeholder="Código do produto" class="form-input" aria-invalid="{{ $errors->has('product_code') ? 'true' : 'false' }}" @if ($errors->has('product_code')) aria-describedby="product-code-error" @endif>@error('product_code')<p id="product-code-error" class="form-error" data-field-error>{{ $message }}</p>@enderror</div>
                    <div class="form-field"><label for="product-name" class="form-label">Nome <span aria-hidden="true">*</span></label><input id="product-name" name="name" type="text" value="{{ old('name') }}" minlength="3" maxlength="100" required autocomplete="off" placeholder="Nome do produto" class="form-input" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" @if ($errors->has('name')) aria-describedby="product-name-error" @endif>@error('name')<p id="product-name-error" class="form-error" data-field-error>{{ $message }}</p>@enderror</div>
                    <div class="form-field sm:col-span-2"><label for="product-description" class="form-label">Descrição <span class="font-normal text-[#9b8a78]">(opcional)</span></label><textarea id="product-description" name="description" rows="3" minlength="3" maxlength="500" placeholder="Informações adicionais sobre o produto" class="form-input min-h-24 resize-y py-3" aria-invalid="{{ $errors->has('description') ? 'true' : 'false' }}" @if ($errors->has('description')) aria-describedby="product-description-error" @endif>{{ old('description') }}</textarea>@error('description')<p id="product-description-error" class="form-error" data-field-error>{{ $message }}</p>@enderror</div>
                    <div class="form-field"><label for="product-stock" class="form-label">Estoque <span aria-hidden="true">*</span></label><input id="product-stock" name="stock" type="number" value="{{ old('stock') }}" min="0" step="1" required inputmode="numeric" placeholder="0" class="form-input" aria-invalid="{{ $errors->has('stock') ? 'true' : 'false' }}" @if ($errors->has('stock')) aria-describedby="product-stock-error" @endif>@error('stock')<p id="product-stock-error" class="form-error" data-field-error>{{ $message }}</p>@enderror</div>
                    <div class="form-field"><label for="product-price" class="form-label">Preço (R$) <span aria-hidden="true">*</span></label><input id="product-price" name="price" type="number" value="{{ old('price') }}" min="0" step="0.01" required inputmode="decimal" placeholder="0,00" class="form-input" aria-invalid="{{ $errors->has('price') ? 'true' : 'false' }}" @if ($errors->has('price')) aria-describedby="product-price-error" @endif>@error('price')<p id="product-price-error" class="form-error" data-field-error>{{ $message }}</p>@enderror</div>
                    <div class="form-field"><label for="product-category" class="form-label">Categoria <span aria-hidden="true">*</span></label><select id="product-category" name="category_id" required class="form-input" aria-invalid="{{ $errors->has('category_id') ? 'true' : 'false' }}" @if ($errors->has('category_id')) aria-describedby="product-category-error" @endif @disabled($categories->isEmpty())><option value="">Selecione uma categoria</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>{{ $category->category_name }}</option>@endforeach</select>@error('category_id')<p id="product-category-error" class="form-error" data-field-error>{{ $message }}</p>@enderror</div>
                    <div class="form-field"><label for="product-active" class="form-label">Situação <span aria-hidden="true">*</span></label><select id="product-active" name="active" required class="form-input" aria-invalid="{{ $errors->has('active') ? 'true' : 'false' }}" @if ($errors->has('active')) aria-describedby="product-active-error" @endif><option value="1" @selected((string) old('active', '1') === '1')>Ativo</option><option value="0" @selected((string) old('active', '1') === '0')>Inativo</option></select>@error('active')<p id="product-active-error" class="form-error" data-field-error>{{ $message }}</p>@enderror</div>
                </div>
                <div class="mt-7 flex flex-col-reverse gap-2 border-t border-[#eee5d9] pt-5 sm:flex-row sm:justify-end"><button type="button" class="inline-flex min-h-11 items-center justify-center rounded-full border border-[#dfd2c1] px-5 text-sm font-semibold text-[#665545] hover:bg-[#f8f3eb] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-close-dialog>Cancelar</button><button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-full bg-[#563d2e] px-5 text-sm font-semibold text-white hover:bg-[#412d21] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e] disabled:cursor-not-allowed disabled:opacity-50" @disabled($categories->isEmpty())><span data-submit-label>Cadastrar produto</span><svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-4"><path d="M4 10h11m-4-4 4 4-4 4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"/></svg></button></div>
            </form>
        </div>
    </dialog>

    <dialog id="delete-dialog" class="app-dialog app-dialog--compact" aria-labelledby="delete-dialog-title">
        <div class="p-6 sm:p-8"><div class="flex items-start gap-4"><span class="grid size-11 shrink-0 place-items-center rounded-2xl bg-[#fbefea] text-[#a04b3b]" aria-hidden="true"><svg viewBox="0 0 20 20" fill="none" class="size-5"><path d="M4.5 6h11m-9.7 0 .6 10h7.2l.6-10M8 6V4h4v2m-3 3v4m2-4v4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"/></svg></span><div><h2 id="delete-dialog-title" class="font-serif text-2xl">Excluir produto?</h2><p class="mt-2 text-sm leading-6 text-[#786858]">Esta ação removerá <strong class="font-semibold text-[#574536]" data-delete-product-name>este produto</strong> do catálogo.</p></div></div>
            <form id="delete-form" action="#" method="POST" class="mt-7 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end" data-delete-url-template="{{ route('products.delete', ['id' => '__PRODUCT_ID__']) }}">@csrf @method('DELETE')<button type="button" class="inline-flex min-h-11 items-center justify-center rounded-full border border-[#dfd2c1] px-5 text-sm font-semibold text-[#665545] hover:bg-[#f8f3eb] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#98633e]" data-close-dialog>Cancelar</button><button type="submit" disabled class="inline-flex min-h-11 items-center justify-center rounded-full bg-[#9b4c3d] px-5 text-sm font-semibold text-white hover:bg-[#843a2e] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#843a2e] disabled:cursor-not-allowed disabled:opacity-50">Excluir produto</button></form>
        </div>
    </dialog>
@endsection
