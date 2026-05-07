/* ===========================================
   APP.JS — Rilas E-commerce (Hierarchical Categories)
   =========================================== */

/* ---------- Navigation ---------- */
function navigate(page) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.getElementById('page-' + page).classList.add('active');
    document.querySelectorAll('.nav-link').forEach(l => {
        l.classList.toggle('active', l.dataset.page === page);
    });
    window.scrollTo({ top: 0, behavior: 'smooth' });
    closeMobileMenu();
    if (page === 'shop') renderShopPage();
    if (page === 'checkout') renderCheckoutSummary();
    if (page === 'admin') renderAdminAll();
    if (page === 'home') renderHomePage();
}

/* ---------- Mobile Menu ---------- */
function toggleMobileMenu() {
    document.getElementById('nav-links').classList.toggle('open');
    document.getElementById('mobile-menu-btn').classList.toggle('open');
}
function closeMobileMenu() {
    document.getElementById('nav-links').classList.remove('open');
    document.getElementById('mobile-menu-btn').classList.remove('open');
}

/* ---------- Toast ---------- */
function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = 'toast toast-' + type;
    toast.textContent = message;
    container.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 300); }, 2600);
}

/* ---------- Cart Drawer ---------- */
function toggleCartDrawer() {
    document.getElementById('cart-drawer').classList.toggle('open');
    document.getElementById('cart-overlay').classList.toggle('open');
    renderCartDrawer();
}

function renderCartDrawer() {
    const container = document.getElementById('cart-drawer-items');
    const footer = document.getElementById('cart-drawer-footer');
    if (cart.length === 0) {
        container.innerHTML = '<div class="cart-empty"><p>Your cart is empty</p></div>';
        footer.style.display = 'none';
        return;
    }
    footer.style.display = 'block';
    let html = '', total = 0;
    cart.forEach(item => {
        const product = products.find(p => p.id === item.productId);
        if (!product) return;
        total += product.price * item.qty;
        html += `<div class="cart-drawer-item">
            <img src="${product.image || 'https://via.placeholder.com/60x60/1a1a2e/eee?text=No+Img'}" alt="${product.name}">
            <div class="cart-item-info">
                <span class="cart-item-name">${product.name}</span>
                <span class="cart-item-price">$${product.price.toFixed(2)}</span>
                <div class="qty-controls">
                    <button onclick="updateCartQty('${item.productId}', -1)">−</button>
                    <span>${item.qty}</span>
                    <button onclick="updateCartQty('${item.productId}', 1)">+</button>
                </div>
            </div>
            <button class="cart-remove-btn" onclick="removeFromCart('${item.productId}')">✕</button>
        </div>`;
    });
    container.innerHTML = html;
    document.getElementById('cart-drawer-total').textContent = '$' + total.toFixed(2);
}

function updateCartCount() {
    document.getElementById('cart-count').textContent = cart.reduce((s, i) => s + i.qty, 0);
}

/* ---------- Cart Actions ---------- */
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;
    if (product.quantity <= 0) { showToast('Out of stock!', 'error'); return; }
    const existing = cart.find(c => c.productId === productId);
    if (existing) {
        if (existing.qty >= product.quantity) { showToast('Max stock reached', 'error'); return; }
        existing.qty++;
    } else {
        cart.push({ productId, qty: 1 });
    }
    persistAll(); updateCartCount();
    showToast(`${product.name} added to cart`, 'success');
}

function updateCartQty(productId, delta) {
    const item = cart.find(c => c.productId === productId);
    if (!item) return;
    const product = products.find(p => p.id === productId);
    item.qty += delta;
    if (item.qty <= 0) { removeFromCart(productId); return; }
    if (product && item.qty > product.quantity) { item.qty = product.quantity; showToast('Max stock reached', 'error'); }
    persistAll(); updateCartCount(); renderCartDrawer(); renderCheckoutSummary();
}

function removeFromCart(productId) {
    cart = cart.filter(c => c.productId !== productId);
    persistAll(); updateCartCount(); renderCartDrawer(); renderCheckoutSummary();
}

/* ============================================
   PRODUCT CARD
   ============================================ */
function productCard(product) {
    const cat = categories.find(c => c.id === product.category);
    const inStock = product.quantity > 0;
    let subName = '';
    if (cat && cat.subcategories && product.subcategory) {
        const sub = cat.subcategories.find(s => s.id === product.subcategory);
        if (sub) subName = sub.name;
    }
    return `<div class="product-card" data-id="${product.id}">
        <div class="product-img-wrap">
            <img src="${product.image || 'https://via.placeholder.com/400x400/1a1a2e/eee?text=No+Image'}" alt="${product.name}" loading="lazy">
            ${!inStock ? '<span class="badge badge-out">Out of Stock</span>' : product.quantity <= 5 ? '<span class="badge badge-low">Low Stock</span>' : ''}
        </div>
        <div class="product-info">
            <span class="product-cat" style="color:${cat ? cat.color : '#888'}">${subName || (cat ? cat.name : 'Uncategorized')}</span>
            <h3 class="product-name">${product.name}</h3>
            <p class="product-desc">${product.description || ''}</p>
            <div class="product-bottom">
                <span class="product-price">$${product.price.toFixed(2)}</span>
                <button class="btn btn-primary btn-sm add-cart-btn" ${!inStock ? 'disabled' : ''} onclick="addToCart('${product.id}')">
                    ${inStock ? 'Add to Cart' : 'Sold Out'}
                </button>
            </div>
        </div>
    </div>`;
}

/* ============================================
   HOME PAGE — Hierarchical Categories
   ============================================ */
function renderHomePage() {
    // Categories — main + expandable subs (like fournipro sitemap)
    const catGrid = document.getElementById('home-categories');
    catGrid.innerHTML = categories.map(c => {
        const productCount = products.filter(p => p.category === c.id).length;
        const subsHtml = (c.subcategories || []).map(sub => {
            const subCount = products.filter(p => p.subcategory === sub.id).length;
            return `<li class="sub-item" onclick="event.stopPropagation(); navigateToSubcategory('${c.id}','${sub.id}')">
                <span class="sub-name">${sub.name}</span>
                <span class="sub-count">${subCount}</span>
            </li>`;
        }).join('');
        return `<div class="category-tree-card" style="--cat-color:${c.color}">
            <div class="cat-tree-header" onclick="toggleCategoryExpand(this)">
                <div class="cat-tree-left">
                    <span class="cat-icon">${c.icon}</span>
                    <div>
                        <h3>${c.name}</h3>
                        <span class="cat-product-count">${productCount} produits</span>
                    </div>
                </div>
                <span class="cat-expand-arrow">▸</span>
            </div>
            <ul class="sub-list">${subsHtml}</ul>
            <div class="cat-tree-footer">
                <button class="btn btn-sm btn-outline" onclick="event.stopPropagation(); navigateToCategory('${c.id}')">Voir tout →</button>
            </div>
        </div>`;
    }).join('');

    // Featured
    const featGrid = document.getElementById('home-featured');
    featGrid.innerHTML = products.slice(0, 8).map(productCard).join('');
}

function toggleCategoryExpand(header) {
    const card = header.closest('.category-tree-card');
    card.classList.toggle('expanded');
}

function navigateToCategory(catId) {
    navigate('shop');
    setTimeout(() => {
        document.querySelectorAll('.category-filter-list .cat-filter-main').forEach(el => {
            el.classList.toggle('active', el.dataset.cat === catId);
        });
        document.querySelectorAll('.category-filter-list .sub-filter-item').forEach(el => el.classList.remove('active'));
        document.querySelector('.category-filter-list .cat-filter-all')?.classList.remove('active');
        currentFilter = { type: 'category', id: catId };
        applyFilters();
    }, 50);
}

function navigateToSubcategory(catId, subId) {
    navigate('shop');
    setTimeout(() => {
        document.querySelectorAll('.category-filter-list .cat-filter-main').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.category-filter-list .sub-filter-item').forEach(el => {
            el.classList.toggle('active', el.dataset.sub === subId);
        });
        document.querySelector('.category-filter-list .cat-filter-all')?.classList.remove('active');
        // Expand parent
        const parentLi = document.querySelector(`.cat-filter-main[data-cat="${catId}"]`);
        if (parentLi) parentLi.classList.add('open');
        currentFilter = { type: 'subcategory', id: subId, parentId: catId };
        applyFilters();
    }, 50);
}

/* ============================================
   SHOP PAGE — Hierarchical Sidebar
   ============================================ */
let currentFilter = { type: 'all' };

function renderShopPage() {
    const list = document.getElementById('category-filter-list');
    let html = '<li class="cat-filter-all active" onclick="filterAll(this)">All Products</li>';
    categories.forEach(c => {
        const subsHtml = (c.subcategories || []).map(sub =>
            `<li class="sub-filter-item" data-sub="${sub.id}" data-parent="${c.id}" onclick="filterSubcategory(this, '${c.id}', '${sub.id}')">
                ${sub.name}
            </li>`
        ).join('');
        html += `<li class="cat-filter-main" data-cat="${c.id}" onclick="filterMainCategory(this, '${c.id}')">
            <div class="cat-filter-row">
                <span style="color:${c.color}">${c.icon}</span>
                <span>${c.name}</span>
                <span class="cat-toggle-arrow" onclick="event.stopPropagation(); toggleSidebarCat(this.closest('.cat-filter-main'))">▸</span>
            </div>
            <ul class="sidebar-sub-list">${subsHtml}</ul>
        </li>`;
    });
    list.innerHTML = html;
    currentFilter = { type: 'all' };
    applyFilters();
}

function filterAll(el) {
    clearFilterHighlights();
    el.classList.add('active');
    currentFilter = { type: 'all' };
    applyFilters();
}

function filterMainCategory(el, catId) {
    clearFilterHighlights();
    el.classList.add('active');
    el.classList.add('open');
    currentFilter = { type: 'category', id: catId };
    applyFilters();
}

function filterSubcategory(el, catId, subId) {
    event.stopPropagation();
    clearFilterHighlights();
    el.classList.add('active');
    const parentLi = el.closest('.cat-filter-main');
    if (parentLi) parentLi.classList.add('open');
    currentFilter = { type: 'subcategory', id: subId, parentId: catId };
    applyFilters();
}

function toggleSidebarCat(li) {
    li.classList.toggle('open');
}

function clearFilterHighlights() {
    document.querySelectorAll('.category-filter-list .active').forEach(el => el.classList.remove('active'));
}

function applyFilters() {
    const search = (document.getElementById('search-input').value || '').toLowerCase();
    const minPrice = parseFloat(document.getElementById('price-min').value) || 0;
    const maxPrice = parseFloat(document.getElementById('price-max').value) || Infinity;
    const sort = document.getElementById('sort-select').value;

    let filtered = products.filter(p => {
        if (currentFilter.type === 'category' && p.category !== currentFilter.id) return false;
        if (currentFilter.type === 'subcategory' && p.subcategory !== currentFilter.id) return false;
        if (search && !p.name.toLowerCase().includes(search) && !(p.description || '').toLowerCase().includes(search)) return false;
        if (p.price < minPrice || p.price > maxPrice) return false;
        return true;
    });

    if (sort === 'price-asc') filtered.sort((a, b) => a.price - b.price);
    else if (sort === 'price-desc') filtered.sort((a, b) => b.price - a.price);
    else if (sort === 'name-asc') filtered.sort((a, b) => a.name.localeCompare(b.name));
    else if (sort === 'name-desc') filtered.sort((a, b) => b.name.localeCompare(a.name));

    document.getElementById('shop-products').innerHTML = filtered.map(productCard).join('');
    document.getElementById('product-count-label').textContent = filtered.length + ' product' + (filtered.length !== 1 ? 's' : '');
    document.getElementById('no-results').style.display = filtered.length === 0 ? 'block' : 'none';
}

/* ============================================
   CHECKOUT
   ============================================ */
function renderCheckoutSummary() {
    const listEl = document.getElementById('checkout-items-list');
    if (cart.length === 0) {
        listEl.innerHTML = '<p class="cart-empty-msg">Your cart is empty.</p>';
        ['summary-subtotal','summary-shipping','summary-tax','summary-total'].forEach(id => document.getElementById(id).textContent = '$0.00');
        return;
    }
    let subtotal = 0, html = '';
    cart.forEach(item => {
        const p = products.find(pr => pr.id === item.productId);
        if (!p) return;
        const line = p.price * item.qty;
        subtotal += line;
        html += `<div class="checkout-item">
            <img src="${p.image || 'https://via.placeholder.com/50'}" alt="${p.name}">
            <div><strong>${p.name}</strong><br><small>Qty: ${item.qty}</small></div>
            <span>$${line.toFixed(2)}</span>
        </div>`;
    });
    listEl.innerHTML = html;
    const shipping = subtotal >= 50 ? 0 : 5.99;
    const tax = subtotal * 0.08;
    document.getElementById('summary-subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('summary-shipping').textContent = shipping === 0 ? 'FREE' : '$' + shipping.toFixed(2);
    document.getElementById('summary-tax').textContent = '$' + tax.toFixed(2);
    document.getElementById('summary-total').textContent = '$' + (subtotal + shipping + tax).toFixed(2);
}

function handleCheckout(e) {
    e.preventDefault();
    if (cart.length === 0) { showToast('Your cart is empty!', 'error'); return; }
    cart.forEach(item => {
        const p = products.find(pr => pr.id === item.productId);
        if (p) p.quantity = Math.max(0, p.quantity - item.qty);
    });
    const subtotal = cart.reduce((s, item) => { const p = products.find(pr => pr.id === item.productId); return s + (p ? p.price * item.qty : 0); }, 0);
    const shipping = subtotal >= 50 ? 0 : 5.99;
    const tax = subtotal * 0.08;
    const order = {
        id: generateId('ORD'), customer: document.getElementById('checkout-fname').value + ' ' + document.getElementById('checkout-lname').value,
        email: document.getElementById('checkout-email').value, items: cart.map(i => ({ ...i })),
        subtotal, shipping, tax, total: subtotal + shipping + tax, date: new Date().toISOString(), status: 'Processing'
    };
    orders.push(order); cart = []; persistAll(); updateCartCount();
    document.getElementById('checkout-form').reset();
    document.getElementById('success-order-number').textContent = 'Order #' + order.id;
    document.getElementById('success-modal').classList.add('open');
    document.getElementById('success-modal-overlay').classList.add('open');
}

function closeSuccessModal() {
    document.getElementById('success-modal').classList.remove('open');
    document.getElementById('success-modal-overlay').classList.remove('open');
}

/* ============================================
   ADMIN PANEL
   ============================================ */
function switchAdminTab(tab) {
    document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.admin-nav-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('admin-tab-' + tab).classList.add('active');
    document.querySelector(`.admin-nav-btn[data-admin-tab="${tab}"]`).classList.add('active');
    renderAdminAll();
}

function renderAdminAll() { renderAdminProducts(); renderAdminCategories(); renderAdminOrders(); }

function renderAdminProducts() {
    const tbody = document.getElementById('admin-products-tbody');
    tbody.innerHTML = products.map(p => {
        const cat = categories.find(c => c.id === p.category);
        let subName = '';
        if (cat && cat.subcategories && p.subcategory) {
            const sub = cat.subcategories.find(s => s.id === p.subcategory);
            if (sub) subName = ' / ' + sub.name;
        }
        return `<tr>
            <td><img src="${p.image || 'https://via.placeholder.com/50'}" class="admin-thumb" alt="${p.name}"></td>
            <td>${p.name}</td>
            <td>${cat ? cat.name : '—'}${subName}</td>
            <td>$${p.price.toFixed(2)}</td>
            <td><span class="stock-badge ${p.quantity <= 0 ? 'out' : p.quantity <= 5 ? 'low' : ''}">${p.quantity}</span></td>
            <td class="action-cell">
                <button class="btn-icon edit" onclick="openProductModal('${p.id}')" title="Edit">✏️</button>
                <button class="btn-icon delete" onclick="deleteProduct('${p.id}')" title="Delete">🗑️</button>
            </td>
        </tr>`;
    }).join('');
}

function renderAdminCategories() {
    const tbody = document.getElementById('admin-categories-tbody');
    tbody.innerHTML = categories.map(c => {
        const count = products.filter(p => p.category === c.id).length;
        const subCount = c.subcategories ? c.subcategories.length : 0;
        return `<tr>
            <td><span class="cat-icon-cell" style="background:${c.color}20;color:${c.color}">${c.icon}</span></td>
            <td>${c.name}<br><small style="color:var(--text3)">${subCount} subcategories</small></td>
            <td>${count}</td>
            <td class="action-cell">
                <button class="btn-icon edit" onclick="openCategoryModal('${c.id}')" title="Edit">✏️</button>
                <button class="btn-icon delete" onclick="deleteCategory('${c.id}')" title="Delete">🗑️</button>
            </td>
        </tr>`;
    }).join('');
}

function renderAdminOrders() {
    const tbody = document.getElementById('admin-orders-tbody');
    if (orders.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:2rem;opacity:.5;">No orders yet</td></tr>';
        return;
    }
    tbody.innerHTML = orders.map(o => {
        const itemCount = o.items.reduce((s, i) => s + i.qty, 0);
        return `<tr>
            <td><code>${o.id.slice(0, 16)}…</code></td>
            <td>${o.customer}</td><td>${itemCount}</td>
            <td>$${o.total.toFixed(2)}</td>
            <td>${new Date(o.date).toLocaleDateString()}</td>
            <td><span class="status-badge status-${o.status.toLowerCase()}">${o.status}</span></td>
        </tr>`;
    }).join('');
}

/* ---------- Product Modal ---------- */
let uploadedImageData = '';

function openProductModal(editId) {
    const modal = document.getElementById('product-modal');
    const overlay = document.getElementById('product-modal-overlay');
    uploadedImageData = '';
    document.getElementById('product-image-preview').innerHTML = '';

    // Build category + subcategory select
    const catSelect = document.getElementById('product-category');
    let opts = '';
    categories.forEach(c => {
        opts += `<optgroup label="${c.icon} ${c.name}">`;
        if (c.subcategories) {
            c.subcategories.forEach(sub => {
                opts += `<option value="${c.id}|${sub.id}">${sub.name}</option>`;
            });
        }
        opts += `<option value="${c.id}|">— ${c.name} (général)</option>`;
        opts += `</optgroup>`;
    });
    catSelect.innerHTML = opts;

    if (editId) {
        const p = products.find(pr => pr.id === editId);
        if (!p) return;
        document.getElementById('product-modal-title').textContent = 'Edit Product';
        document.getElementById('product-edit-id').value = editId;
        document.getElementById('product-name').value = p.name;
        catSelect.value = p.category + '|' + (p.subcategory || '');
        document.getElementById('product-price').value = p.price;
        document.getElementById('product-quantity').value = p.quantity;
        document.getElementById('product-description').value = p.description || '';
        document.getElementById('product-image').value = p.image || '';
    } else {
        document.getElementById('product-modal-title').textContent = 'Add Product';
        document.getElementById('product-form').reset();
        document.getElementById('product-edit-id').value = '';
    }
    modal.classList.add('open'); overlay.classList.add('open');
}

function closeProductModal() {
    document.getElementById('product-modal').classList.remove('open');
    document.getElementById('product-modal-overlay').classList.remove('open');
}

function handleImageUpload(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        uploadedImageData = ev.target.result;
        document.getElementById('product-image-preview').innerHTML = `<img src="${uploadedImageData}" alt="Preview">`;
    };
    reader.readAsDataURL(file);
}

function saveProduct(e) {
    e.preventDefault();
    const editId = document.getElementById('product-edit-id').value;
    const name = document.getElementById('product-name').value.trim();
    const catVal = document.getElementById('product-category').value.split('|');
    const category = catVal[0];
    const subcategory = catVal[1] || '';
    const price = parseFloat(document.getElementById('product-price').value);
    const quantity = parseInt(document.getElementById('product-quantity').value, 10);
    const description = document.getElementById('product-description').value.trim();
    let image = document.getElementById('product-image').value.trim();
    if (uploadedImageData) image = uploadedImageData;

    if (editId) {
        const p = products.find(pr => pr.id === editId);
        if (p) Object.assign(p, { name, category, subcategory, price, quantity, description, image });
        showToast('Product updated!', 'success');
    } else {
        products.push({ id: generateId('p'), name, category, subcategory, price, quantity, description, image });
        showToast('Product added!', 'success');
    }
    persistAll(); closeProductModal(); renderAdminProducts(); renderShopPage();
}

function deleteProduct(id) {
    if (!confirm('Delete this product?')) return;
    products = products.filter(p => p.id !== id);
    cart = cart.filter(c => c.productId !== id);
    persistAll(); updateCartCount(); renderAdminProducts();
    showToast('Product deleted', 'success');
}

/* ---------- Category Modal ---------- */
function openCategoryModal(editId) {
    const modal = document.getElementById('category-modal');
    const overlay = document.getElementById('category-modal-overlay');

    if (editId) {
        const c = categories.find(cat => cat.id === editId);
        if (!c) return;
        document.getElementById('category-modal-title').textContent = 'Edit Category';
        document.getElementById('category-edit-id').value = editId;
        document.getElementById('category-name').value = c.name;
        document.getElementById('category-icon').value = c.icon;
        document.getElementById('category-color').value = c.color;
        document.getElementById('category-subcategories').value = (c.subcategories || []).map(s => s.name).join('\n');
    } else {
        document.getElementById('category-modal-title').textContent = 'Add Category';
        document.getElementById('category-form').reset();
        document.getElementById('category-edit-id').value = '';
    }
    modal.classList.add('open'); overlay.classList.add('open');
}

function closeCategoryModal() {
    document.getElementById('category-modal').classList.remove('open');
    document.getElementById('category-modal-overlay').classList.remove('open');
}

function saveCategory(e) {
    e.preventDefault();
    const editId = document.getElementById('category-edit-id').value;
    const name = document.getElementById('category-name').value.trim();
    const icon = document.getElementById('category-icon').value.trim() || '📦';
    const color = document.getElementById('category-color').value;
    const subsText = document.getElementById('category-subcategories').value.trim();
    const subNames = subsText ? subsText.split('\n').map(s => s.trim()).filter(Boolean) : [];

    if (editId) {
        const c = categories.find(cat => cat.id === editId);
        if (c) {
            c.name = name; c.icon = icon; c.color = color;
            // Merge subcategories: keep existing IDs for matches, add new ones
            const oldSubs = c.subcategories || [];
            c.subcategories = subNames.map(sName => {
                const existing = oldSubs.find(s => s.name === sName);
                return existing || { id: generateId('sub'), name: sName };
            });
        }
        showToast('Category updated!', 'success');
    } else {
        const newCat = {
            id: generateId('cat'), name, icon, color,
            subcategories: subNames.map(sName => ({ id: generateId('sub'), name: sName }))
        };
        categories.push(newCat);
        showToast('Category added!', 'success');
    }
    persistAll(); closeCategoryModal(); renderAdminCategories();
}

function deleteCategory(id) {
    if (!confirm('Delete this category and all its subcategories?')) return;
    categories = categories.filter(c => c.id !== id);
    persistAll(); renderAdminCategories();
    showToast('Category deleted', 'success');
}

/* ---------- Scroll header ---------- */
window.addEventListener('scroll', () => {
    document.getElementById('main-header').classList.toggle('scrolled', window.scrollY > 30);
});

/* ---------- Init ---------- */
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    renderHomePage();
});
