/** Shared V5 interactions for the WordPress theme. */
(function () {
  'use strict';
  var key = 'sw_inquiry_cart';
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
  function byId(id) { return document.getElementById(id); }
  function cart() {
    try { var value = JSON.parse(localStorage.getItem(key) || '[]'); return Array.isArray(value) ? value : []; }
    catch (e) { return []; }
  }
  function save(items) { try { localStorage.setItem(key, JSON.stringify(items)); } catch (e) {} renderCart(); }
  function modal(id) { var el = byId(id); if (el && window.bootstrap) bootstrap.Modal.getOrCreateInstance(el).show(); }
  function escapeHtml(value) { var el = document.createElement('span'); el.textContent = String(value || ''); return el.innerHTML; }
  function validQty(value, min) { return Math.max(min || 1, parseInt(value, 10) || min || 1); }
  function currentQty() { var input = byId('sw-detail-qty'); return input ? validQty(input.value, parseInt(input.min, 10) || 1) : 1; }
  function renderCart() {
    var items = cart(), count = byId('sw-cart-count'), body = byId('sw-cart-table-body');
    if (count) count.textContent = String(items.length);
    if (byId('sw-cart-empty')) byId('sw-cart-empty').classList.toggle('d-none', items.length > 0);
    if (byId('sw-cart-items')) byId('sw-cart-items').classList.toggle('d-none', items.length === 0);
    if (byId('sw-submit-cart-inquiry')) byId('sw-submit-cart-inquiry').disabled = items.length === 0;
    if (body) body.innerHTML = items.map(function (item) { return '<tr><td>' + escapeHtml(item.name) + '</td><td>—</td><td><input type="number" class="form-control form-control-sm sw-cart-qty" min="1" value="' + validQty(item.qty, 1) + '" data-qty-id="' + escapeHtml(item.id) + '"></td><td class="text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-id="' + escapeHtml(item.id) + '" aria-label="Remove"><i class="bi bi-trash"></i></button></td></tr>'; }).join('');
    var selected = byId('sw-selected-products'); if (selected) selected.textContent = '';
    document.querySelectorAll('.sw-add-to-inquiry').forEach(function (button) {
      var found = items.some(function (item) { return String(item.id) === button.dataset.productId; });
      button.classList.toggle('is-added', found);
    });
  }
  function openInquiry(button) {
    var product = byId('sw_product'), quantity = byId('sw_quantity'), message = byId('sw_message');
    if (product) product.value = button.dataset.product || '';
    if (quantity) quantity.value = button.dataset.qty ? validQty(button.dataset.qty, 1) : '';
    if (byId('sw_products')) byId('sw_products').value = '';
    if (message) message.value = button.dataset.message || '';
    modal('inquiryModal');
  }
  function updateTier() {
    var qty = currentQty(), rows = Array.from(document.querySelectorAll('.sw-tier-row'));
    var active = -1;
    rows.forEach(function (row, i) { if (qty >= parseInt(row.dataset.min, 10)) active = i; });
    rows.forEach(function (row, i) { row.classList.toggle('active', i === active); });
    var detail = byId('sw-detail-qty');
    if (detail) document.querySelectorAll('.sw-product-info .sw-add-to-inquiry,.sw-product-info .sw-inquiry-btn').forEach(function (button) { button.dataset.qty = String(qty); });
  }
  function setMainImage(url, source) {
    var image = byId('sw-main-image'); if (!image || !url) return;
    image.src = url;
    document.querySelectorAll('.gallery-thumb').forEach(function (button) { button.classList.toggle('active', button === source || button.dataset.full === url); });
    document.querySelectorAll('.sw-color').forEach(function (button) { var selected = button.dataset.full === url; button.classList.toggle('active', selected); button.setAttribute('aria-pressed', selected ? 'true' : 'false'); });
  }
  function initMotion() {
    var sections = document.querySelectorAll('main section:not(.hero-v3)');
    var items = document.querySelectorAll('.band-photo,.step-card,.product-cell,.sw-category-cell,.sw-detail-image');
    if (reduce.matches || !('IntersectionObserver' in window)) return;
    sections.forEach(function (el) { el.classList.add('reveal'); });
    items.forEach(function (el, i) { el.classList.add('reveal-item'); el.style.transitionDelay = (i % 4 * 70) + 'ms'; });
    var observer = new IntersectionObserver(function (entries) { entries.forEach(function (entry) { if (entry.isIntersecting) { entry.target.classList.add('in'); observer.unobserve(entry.target); } }); }, { threshold: .12 });
    document.querySelectorAll('.reveal,.reveal-item').forEach(function (el) { observer.observe(el); });
  }
  function initCounters() {
    var els = document.querySelectorAll('.count-up');
    if (reduce.matches || !('IntersectionObserver' in window)) { els.forEach(function (el) { el.textContent = el.dataset.count; }); return; }
    var observer = new IntersectionObserver(function (entries) { entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      var el = entry.target, target = parseInt(el.dataset.count, 10) || 0, started = null;
      function tick(time) { if (started === null) started = time; var progress = Math.min((time - started) / 1000, 1); el.textContent = Math.round(target * (1 - Math.pow(1 - progress, 3))); if (progress < 1) requestAnimationFrame(tick); }
      el.textContent = '0'; requestAnimationFrame(tick); observer.unobserve(el);
    }); }, { threshold: .4 });
    els.forEach(function (el) { observer.observe(el); });
  }
  function initScroll() {
    var header = document.querySelector('.site-header'), images = document.querySelectorAll('.hero-carousel .carousel-item img'), pending = false;
    function apply() { var y = window.scrollY || 0; if (header) header.classList.toggle('is-scrolled', y > 10); if (!reduce.matches && y < 900) images.forEach(function (image) { image.style.transform = 'scale(1.14) translateY(' + Math.min(y * .10, 60) + 'px)'; }); pending = false; }
    window.addEventListener('scroll', function () { if (!pending) { pending = true; requestAnimationFrame(apply); } }, { passive: true }); apply();
  }
  function initFilters() {
    document.querySelectorAll('.js-filter').forEach(function (button) { button.addEventListener('click', function () {
      document.querySelectorAll('.js-filter').forEach(function (b) { b.classList.toggle('active', b === button); b.classList.toggle('btn-primary', b === button); b.classList.toggle('btn-outline-primary', b !== button); });
      var filter = button.dataset.filter, visible = 0;
      document.querySelectorAll('.product-cell').forEach(function (cell) { var show = filter === 'all' || (cell.dataset.group || '').split(' ').indexOf(filter) !== -1; cell.hidden = !show; if (show) visible++; });
      if (byId('sw-filter-empty')) byId('sw-filter-empty').classList.toggle('d-none', visible > 0);
    }); });
  }
  function initForm() {
    var form = byId('sw-inquiry-form'); if (!form) return;
    form.addEventListener('submit', function (event) {
      var email = byId('sw_email'), phone = byId('sw_phone');
      email.classList.remove('is-invalid'); phone.classList.remove('is-invalid');
      var emailValue = email.value.trim(), phoneValue = phone.value.trim();
      if (!emailValue && !phoneValue) { event.preventDefault(); email.classList.add('is-invalid'); phone.classList.add('is-invalid'); return; }
      if (emailValue && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)) { event.preventDefault(); email.classList.add('is-invalid'); return; }
      var submit = form.querySelector('[type=submit]'); if (submit) { submit.disabled = true; submit.textContent = (window.swData && swData.i18n && swData.i18n.submitting) || 'Submitting…'; }
    });
    if (new URLSearchParams(location.search).get('inquiry') === 'success') {
      var success = byId('swSuccessToast'); if (success && window.bootstrap) bootstrap.Toast.getOrCreateInstance(success).show();
    }
  }
  document.addEventListener('DOMContentLoaded', function () {
    renderCart(); initMotion(); initCounters(); initScroll(); initFilters(); initForm(); updateTier();
    if (reduce.matches && byId('swHeroCarousel') && window.bootstrap) bootstrap.Carousel.getOrCreateInstance(byId('swHeroCarousel')).pause();
    document.addEventListener('click', function (event) {
      var button = event.target.closest('button'); if (!button) return;
      if (button.matches('.sw-inquiry-btn')) { event.preventDefault(); if (button.closest('.sw-product-info')) button.dataset.qty = String(currentQty()); openInquiry(button); }
      if (button.matches('.sw-add-to-inquiry')) {
        event.preventDefault(); var items = cart(), id = button.dataset.productId, qty = button.closest('.sw-product-info') ? currentQty() : validQty(button.dataset.qty, 1);
        var existing = items.find(function (item) { return String(item.id) === id; });
        if (existing) existing.qty += qty; else items.push({ id: id, name: button.dataset.productName || '', qty: qty });
        save(items); var old = button.innerHTML; button.textContent = 'Added ✓'; setTimeout(function () { button.innerHTML = old; }, 1100);
      }
      if (button.matches('[data-remove-id]')) { event.preventDefault(); save(cart().filter(function (item) { return String(item.id) !== button.dataset.removeId; })); }
      if (button.id === 'sw-clear-cart') save([]);
      if (button.id === 'sw-submit-cart-inquiry') {
        var items = cart(); if (!items.length) return;
        var list = items.map(function (item) { return item.name + ' × ' + item.qty; }).join('\n');
        var product = byId('sw_product'), message = byId('sw_message'); if (product) product.value = '';
        if (byId('sw_products')) byId('sw_products').value = items.map(function (item) { return item.name + ' × ' + item.qty; }).join('|');
        if (message) message.value = 'Products requested:\n' + list;
        var cartModal = byId('inquiryCartModal'); if (cartModal && window.bootstrap) bootstrap.Modal.getOrCreateInstance(cartModal).hide();
        if (cartModal) cartModal.addEventListener('hidden.bs.modal', function once() { cartModal.removeEventListener('hidden.bs.modal', once); modal('inquiryModal'); });
      }
      if (button.matches('.gallery-thumb')) setMainImage(button.dataset.full, button);
      if (button.matches('.sw-color')) {
        document.querySelectorAll('.sw-color').forEach(function (b) { b.classList.toggle('active', b === button); b.setAttribute('aria-pressed', b === button ? 'true' : 'false'); });
        setMainImage(button.dataset.full, null);
      }
      if (button.matches('.sw-qty-plus,.sw-qty-minus')) { var input = byId('sw-detail-qty'); if (input) { var step = parseInt(input.step, 10) || 10; input.value = validQty(currentQty() + (button.matches('.sw-qty-plus') ? step : -step), parseInt(input.min, 10)); updateTier(); } }
    });
    document.addEventListener('change', function (event) {
      if (event.target.id === 'sw-detail-qty') { event.target.value = currentQty(); updateTier(); }
      if (event.target.matches('.sw-cart-qty')) { var items = cart(), item = items.find(function (i) { return String(i.id) === event.target.dataset.qtyId; }); if (item) { item.qty = validQty(event.target.value, 1); save(items); } }
    });
    document.addEventListener('input', function (event) { if (event.target.id === 'sw-detail-qty') updateTier(); });
  });
})();
