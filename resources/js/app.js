const productFormStateKey = 'bakery-product-form-state';

const productDialog = document.querySelector('#product-dialog');
const productForm = document.querySelector('#product-form');
const deleteDialog = document.querySelector('#delete-dialog');
const deleteForm = document.querySelector('#delete-form');

function safeSessionStorage(value) {
    try {
        if (value === undefined) {
            return sessionStorage.getItem(productFormStateKey);
        }

        if (value === null) {
            sessionStorage.removeItem(productFormStateKey);
            return;
        }

        sessionStorage.setItem(productFormStateKey, JSON.stringify(value));
    } catch {
        // Storage may be unavailable in private browsing; the forms still work.
    }
}

function clearValidationPresentation() {
    if (!productForm) return;

    productForm.querySelectorAll('[data-field-error], [data-validation-summary]').forEach((element) => {
        element.hidden = true;
    });

    productForm.querySelectorAll('[aria-invalid]').forEach((field) => {
        field.setAttribute('aria-invalid', 'false');
        field.removeAttribute('aria-describedby');
    });
}

function setProductDialogMode(mode, productId = null, product = null, restore = false) {
    if (!productDialog || !productForm) return;

    const isEditing = mode === 'edit';
    const methodField = productForm.querySelector('input[name="_method"]');
    const title = productDialog.querySelector('#product-dialog-title');
    const description = productDialog.querySelector('[data-dialog-description]');
    const submitLabel = productDialog.querySelector('[data-submit-label]');

    productForm.dataset.mode = mode;
    productForm.dataset.productId = isEditing && productId ? String(productId) : '';
    productForm.action = isEditing
        ? productForm.dataset.updateUrlTemplate.replace('__PRODUCT_ID__', encodeURIComponent(productId))
        : productForm.dataset.storeUrl;

    if (methodField) methodField.disabled = !isEditing;

    title.textContent = isEditing ? 'Editar produto' : 'Novo produto';
    description.textContent = isEditing
        ? 'Atualize as informações deste produto.'
        : 'Preencha os dados do produto.';
    submitLabel.textContent = isEditing ? 'Salvar alterações' : 'Cadastrar produto';

    if (restore) return;

    clearValidationPresentation();

    if (!isEditing) {
        productForm.querySelector('[name="product_code"]').value = '';
        productForm.querySelector('[name="name"]').value = '';
        productForm.querySelector('[name="description"]').value = '';
        productForm.querySelector('[name="stock"]').value = '';
        productForm.querySelector('[name="price"]').value = '';
        productForm.querySelector('[name="category_id"]').value = '';
        productForm.querySelector('[name="active"]').value = '1';
        return;
    }

    productForm.querySelector('[name="product_code"]').value = product?.code ?? '';
    productForm.querySelector('[name="name"]').value = product?.name ?? '';
    productForm.querySelector('[name="description"]').value = product?.description ?? '';
    productForm.querySelector('[name="stock"]').value = product?.stock ?? '';
    productForm.querySelector('[name="price"]').value = product?.price ?? '';
    productForm.querySelector('[name="category_id"]').value = product?.category ?? '';
    productForm.querySelector('[name="active"]').value = product?.active === '0' ? '0' : '1';
}

function openProductDialog(mode, productId = null, product = null) {
    if (!productDialog) return;

    setProductDialogMode(mode, productId, product);
    productDialog.showModal();

    requestAnimationFrame(() => {
        const firstField = productDialog.querySelector('input:not([type="hidden"]), textarea, select');
        firstField?.focus();
    });
}

document.querySelectorAll('[data-open-product-modal="create"]').forEach((button) => {
    button.addEventListener('click', () => openProductDialog('create'));
});

document.querySelectorAll('[data-edit-product]').forEach((button) => {
    button.addEventListener('click', () => {
        openProductDialog('edit', button.dataset.productId, {
            code: button.dataset.productCode,
            name: button.dataset.productName,
            description: button.dataset.productDescription,
            stock: button.dataset.productStock,
            price: button.dataset.productPrice,
            category: button.dataset.productCategory,
            active: button.dataset.productActive,
        });
    });
});

document.querySelectorAll('[data-delete-product]').forEach((button) => {
    button.addEventListener('click', () => {
        if (!deleteDialog || !deleteForm) return;

        deleteForm.action = deleteForm.dataset.deleteUrlTemplate.replace(
            '__PRODUCT_ID__',
            encodeURIComponent(button.dataset.productId),
        );
        deleteForm.querySelector('[type="submit"]').disabled = false;
        deleteDialog.querySelector('[data-delete-product-name]').textContent = button.dataset.productName;
        deleteDialog.showModal();
        requestAnimationFrame(() => deleteForm.querySelector('[type="button"]')?.focus());
    });
});

document.querySelectorAll('[data-close-dialog]').forEach((button) => {
    button.addEventListener('click', () => button.closest('dialog')?.close());
});

document.querySelectorAll('dialog').forEach((dialog) => {
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) dialog.close();
    });
});

productForm?.addEventListener('submit', () => {
    safeSessionStorage({
        mode: productForm.dataset.mode || 'create',
        productId: productForm.dataset.productId || null,
    });
});

deleteForm?.addEventListener('submit', () => safeSessionStorage(null));

const successNotice = document.querySelector('[data-success-notice]');
if (successNotice) safeSessionStorage(null);

if (productDialog && productDialog.dataset.hasErrors !== 'true') {
    setProductDialogMode('create', null, null, true);
}

if (productDialog?.dataset.hasErrors === 'true') {
    let previousFormState = null;

    try {
        previousFormState = JSON.parse(safeSessionStorage());
    } catch {
        previousFormState = null;
    }

    const mode = previousFormState?.mode === 'edit' && previousFormState.productId ? 'edit' : 'create';
    setProductDialogMode(mode, previousFormState?.productId ?? null, null, true);
    productDialog.showModal();

    requestAnimationFrame(() => {
        productDialog.querySelector('[aria-invalid="true"]')?.focus();
    });
} else {
    safeSessionStorage(null);
}

const searchInput = document.querySelector('#product-search');
const statusFilter = document.querySelector('#product-status-filter');
const productRows = [...document.querySelectorAll('[data-product-row]')];
const noFilterResults = document.querySelector('#no-filter-results');
const filterStatus = document.querySelector('#product-filter-status');

function filterProducts() {
    if (!productRows.length) return;

    const searchTerm = searchInput?.value.trim().toLocaleLowerCase('pt-BR') ?? '';
    const activeFilter = statusFilter?.value ?? 'all';
    let visibleRows = 0;

    productRows.forEach((row) => {
        const matchesText = row.dataset.search.includes(searchTerm);
        const matchesStatus = activeFilter === 'all' || row.dataset.active === activeFilter;
        const isVisible = matchesText && matchesStatus;

        row.hidden = !isVisible;
        if (isVisible) visibleRows += 1;
    });

    if (noFilterResults) noFilterResults.hidden = visibleRows !== 0;
    if (filterStatus) {
        filterStatus.textContent = `${visibleRows} ${visibleRows === 1 ? 'produto encontrado' : 'produtos encontrados'}.`;
    }
}

searchInput?.addEventListener('input', filterProducts);
statusFilter?.addEventListener('change', filterProducts);

const categoryDialog = document.querySelector('#category-dialog');
const categoryForm = document.querySelector('#category-form');
const deleteCategoryDialog = document.querySelector('#delete-category-dialog');
const deleteCategoryForm = document.querySelector('#delete-category-form');
const categoryFormStateKey = 'bakery-category-form-state';

function safeCategoryStorage(value) {
    try {
        if (value === undefined) return sessionStorage.getItem(categoryFormStateKey);
        if (value === null) return sessionStorage.removeItem(categoryFormStateKey);

        sessionStorage.setItem(categoryFormStateKey, JSON.stringify(value));
    } catch {
        // The category form remains usable when browser storage is unavailable.
    }
}

function clearCategoryValidation() {
    if (!categoryForm) return;

    categoryForm.querySelectorAll('[data-category-field-error], [data-category-validation-summary]').forEach((element) => {
        element.hidden = true;
    });
    categoryForm.querySelector('[name="category_name"]')?.setAttribute('aria-invalid', 'false');
    categoryForm.querySelector('[name="category_name"]')?.removeAttribute('aria-describedby');
}

function setCategoryDialogMode(mode, categoryId = null, categoryName = '', restore = false) {
    if (!categoryDialog || !categoryForm) return;

    const isEditing = mode === 'edit';
    const methodField = categoryForm.querySelector('input[name="_method"]');

    categoryForm.dataset.mode = mode;
    categoryForm.dataset.categoryId = isEditing && categoryId ? String(categoryId) : '';
    categoryForm.action = isEditing
        ? categoryForm.dataset.updateUrlTemplate.replace('__CATEGORY_ID__', encodeURIComponent(categoryId))
        : categoryForm.dataset.storeUrl;

    if (methodField) methodField.disabled = !isEditing;

    categoryDialog.querySelector('#category-dialog-title').textContent = isEditing
        ? 'Editar categoria'
        : 'Nova categoria';
    categoryDialog.querySelector('[data-category-dialog-description]').textContent = isEditing
        ? 'Atualize o nome desta categoria.'
        : 'Dê um nome claro para o grupo.';
    categoryDialog.querySelector('[data-category-submit-label]').textContent = isEditing
        ? 'Salvar alterações'
        : 'Cadastrar categoria';

    if (restore) return;

    clearCategoryValidation();
    categoryForm.querySelector('[name="category_name"]').value = categoryName;
}

function openCategoryDialog(mode = 'create', categoryId = null, categoryName = '', restore = false) {
    if (!categoryDialog || !categoryForm) return;

    setCategoryDialogMode(mode, categoryId, categoryName, restore);

    categoryDialog.showModal();
    requestAnimationFrame(() => categoryForm.querySelector('[name="category_name"]')?.focus());
}

document.querySelectorAll('[data-open-category-modal]').forEach((button) => {
    button.addEventListener('click', () => openCategoryDialog('create'));
});

document.querySelectorAll('[data-edit-category]').forEach((button) => {
    button.addEventListener('click', () => {
        openCategoryDialog('edit', button.dataset.categoryId, button.dataset.categoryName);
    });
});

document.querySelectorAll('[data-delete-category]').forEach((button) => {
    button.addEventListener('click', () => {
        if (!deleteCategoryDialog || !deleteCategoryForm) return;

        deleteCategoryForm.action = deleteCategoryForm.dataset.deleteUrlTemplate.replace(
            '__CATEGORY_ID__',
            encodeURIComponent(button.dataset.categoryId),
        );
        deleteCategoryForm.querySelector('[type="submit"]').disabled = false;
        deleteCategoryDialog.querySelector('[data-delete-category-name]').textContent = button.dataset.categoryName;
        deleteCategoryDialog.showModal();
        requestAnimationFrame(() => deleteCategoryForm.querySelector('[type="button"]')?.focus());
    });
});

categoryForm?.addEventListener('submit', () => {
    safeCategoryStorage({
        mode: categoryForm.dataset.mode || 'create',
        categoryId: categoryForm.dataset.categoryId || null,
    });
});

deleteCategoryForm?.addEventListener('submit', () => safeCategoryStorage(null));

if (document.querySelector('[data-category-success]')) safeCategoryStorage(null);

if (categoryDialog?.dataset.hasErrors === 'true') {
    let previousState = null;

    try {
        previousState = JSON.parse(safeCategoryStorage());
    } catch {
        previousState = null;
    }

    const mode = previousState?.mode === 'edit' && previousState.categoryId ? 'edit' : 'create';
    openCategoryDialog(mode, previousState?.categoryId ?? null, '', true);
} else if (categoryDialog) {
    safeCategoryStorage(null);
    setCategoryDialogMode('create', null, '', true);
}

const categorySearch = document.querySelector('#category-search');
const categoryRows = [...document.querySelectorAll('[data-category-row]')];
const noCategoryResults = document.querySelector('#no-category-results');
const categoryFilterStatus = document.querySelector('#category-filter-status');

categorySearch?.addEventListener('input', () => {
    const searchTerm = categorySearch.value.trim().toLocaleLowerCase('pt-BR');
    let visibleRows = 0;

    categoryRows.forEach((row) => {
        const isVisible = row.dataset.search.includes(searchTerm);
        row.hidden = !isVisible;
        if (isVisible) visibleRows += 1;
    });

    if (noCategoryResults) noCategoryResults.hidden = visibleRows !== 0;
    if (categoryFilterStatus) {
        categoryFilterStatus.textContent = `${visibleRows} ${visibleRows === 1 ? 'categoria encontrada' : 'categorias encontradas'}.`;
    }
});
