/**
 * Sports Wholesale Theme - Main JavaScript
 *
 * Handles: inquiry modal, gallery switching, form validation,
 * share button, toast notifications, inquiry cart.
 *
 * @package SportsWholesale
 */

(function () {
    'use strict';

    /* ==========================================================
       Inquiry Cart (localStorage based)
       ========================================================== */
    var INQUIRY_CART_KEY = 'sw_inquiry_cart';

    function getCart() {
        try {
            var data = localStorage.getItem(INQUIRY_CART_KEY);
            return data ? JSON.parse(data) : [];
        } catch (e) {
            return [];
        }
    }

    function saveCart(cart) {
        try {
            localStorage.setItem(INQUIRY_CART_KEY, JSON.stringify(cart));
        } catch (e) {}
    }

    function addToCart(productId, productName) {
        var cart = getCart();
        var exists = cart.some(function (item) { return item.id === productId; });
        if (exists) return false;
        
        cart.push({ id: productId, name: productName });
        saveCart(cart);
        updateCartUI();
        return true;
    }

    function removeFromCart(productId) {
        var cart = getCart().filter(function (item) { return item.id !== productId; });
        saveCart(cart);
        updateCartUI();
        renderCartItems();
    }

    function clearCart() {
        saveCart([]);
        updateCartUI();
        renderCartItems();
    }

    function updateCartUI() {
        var cart = getCart();
        var count = cart.length;
        
        // Update floating button
        var cartBtn = document.getElementById('sw-inquiry-cart-btn');
        var cartCount = document.getElementById('sw-cart-count');
        
        if (cartBtn) {
            if (count > 0) {
                cartBtn.classList.remove('d-none');
            } else {
                cartBtn.classList.add('d-none');
            }
        }
        
        if (cartCount) {
            cartCount.textContent = count;
        }
        
        // Update add-to-cart buttons
        document.querySelectorAll('.sw-add-to-inquiry').forEach(function (btn) {
            var productId = btn.getAttribute('data-product-id');
            var inCart = cart.some(function (item) { return item.id === productId; });
            
            if (inCart) {
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-success');
                btn.querySelector('i').className = 'bi bi-cart-check';
                btn.disabled = true;
            } else {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');
                btn.querySelector('i').className = 'bi bi-cart-plus';
                btn.disabled = false;
            }
        });
        
        // Update hidden field for form submission
        var productsField = document.getElementById('sw_products');
        if (productsField) {
            productsField.value = cart.map(function (item) { return item.name; }).join('|');
        }
        
        // Update selected products display
        var selectedProducts = document.getElementById('sw-selected-products');
        if (selectedProducts) {
            if (count > 0) {
                selectedProducts.innerHTML = cart.map(function (item) {
                    return '<span class="badge bg-primary me-1 mb-1">' + 
                           escapeHtml(item.name) + 
                           ' <button type="button" class="btn-close btn-close-white ms-1" data-remove-id="' + 
                           item.id + '" style="font-size:0.6em;"></button></span>';
                }).join('');
            } else {
                selectedProducts.innerHTML = '';
            }
        }
        
        // Update submit button
        var submitBtn = document.getElementById('sw-submit-cart-inquiry');
        if (submitBtn) {
            submitBtn.disabled = count === 0;
        }
    }

    function renderCartItems() {
        var cart = getCart();
        var emptyEl = document.getElementById('sw-cart-empty');
        var itemsEl = document.getElementById('sw-cart-items');
        var tbody = document.getElementById('sw-cart-table-body');
        
        if (!emptyEl || !itemsEl || !tbody) return;
        
        if (cart.length === 0) {
            emptyEl.classList.remove('d-none');
            itemsEl.classList.add('d-none');
            return;
        }
        
        emptyEl.classList.add('d-none');
        itemsEl.classList.remove('d-none');
        
        tbody.innerHTML = cart.map(function (item, index) {
            return '<tr>' +
                '<td>' + escapeHtml(item.name) + '</td>' +
                '<td>-</td>' +
                '<td class="text-center"><input type="number" class="form-control form-control-sm mx-auto" style="width:70px" min="1" value="1" data-qty-id="' + item.id + '"></td>' +
                '<td class="text-end"><button type="button" class="btn btn-outline-danger btn-sm" data-remove-id="' + item.id + '"><i class="bi bi-trash"></i></button></td>' +
                '</tr>';
        }).join('');
    }

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /* ==========================================================
       Inquiry Modal Handler
       ========================================================== */
    function initInquiryButtons() {
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.sw-inquiry-btn');
            if (!btn) return;

            e.preventDefault();
            var productName = btn.getAttribute('data-product') || '';
            var modal = document.getElementById('inquiryModal');
            if (!modal) return;

            var productInput = modal.querySelector('#sw_product');
            if (productInput && productName) {
                productInput.value = productName;
            }

            var bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            bsModal.show();
        });
    }

    /* ==========================================================
       Inquiry Cart Buttons Handler
       ========================================================== */
    function initInquiryCart() {
        // Add to cart buttons
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.sw-add-to-inquiry');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();
            
            var productId = btn.getAttribute('data-product-id');
            var productName = btn.getAttribute('data-product-name');
            
            if (addToCart(productId, productName)) {
                // Show brief feedback
                var originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check"></i>';
                setTimeout(function () {
                    btn.innerHTML = originalHtml;
                }, 1000);
            }
        });
        
        // Open cart button
        var openCartBtn = document.getElementById('sw-open-cart');
        if (openCartBtn) {
            openCartBtn.addEventListener('click', function () {
                renderCartItems();
                var modal = document.getElementById('inquiryCartModal');
                if (modal) {
                    var bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                    bsModal.show();
                }
            });
        }
        
        // Clear cart button
        document.addEventListener('click', function (e) {
            if (e.target.closest('#sw-clear-cart')) {
                clearCart();
            }
        });
        
        // Remove item buttons (in cart modal and form)
        document.addEventListener('click', function (e) {
            var removeBtn = e.target.closest('[data-remove-id]');
            if (removeBtn) {
                var productId = removeBtn.getAttribute('data-remove-id');
                removeFromCart(productId);
            }
        });
        
        // Submit cart inquiry button
        var submitCartBtn = document.getElementById('sw-submit-cart-inquiry');
        if (submitCartBtn) {
            submitCartBtn.addEventListener('click', function () {
                var cart = getCart();
                if (cart.length === 0) return;
                
                // Close cart modal
                var cartModal = document.getElementById('inquiryCartModal');
                if (cartModal) {
                    var bsCartModal = bootstrap.Modal.getInstance(cartModal);
                    if (bsCartModal) bsCartModal.hide();
                }
                
                // Open inquiry modal
                var inquiryModal = document.getElementById('inquiryModal');
                if (inquiryModal) {
                    var bsInquiryModal = bootstrap.Modal.getOrCreateInstance(inquiryModal);
                    bsInquiryModal.show();
                }
            });
        }
        
        // Initialize cart UI on load
        updateCartUI();
    }

    /* ==========================================================
       Inquiry Form Validation & Submission
       ========================================================== */
    function initInquiryForm() {
        var form = document.getElementById('sw-inquiry-form');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            var name = form.querySelector('[name="sw_name"]');
            var email = form.querySelector('[name="sw_email"]');
            var isValid = true;

            // Reset
            form.querySelectorAll('.is-invalid').forEach(function (el) {
                el.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(function (el) {
                el.remove();
            });

            if (!name || !name.value.trim()) {
                markInvalid(name, swData.i18n.required);
                isValid = false;
            }

            if (!email || !email.value.trim() || !isValidEmail(email.value)) {
                markInvalid(email, swData.i18n.required);
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return;
            }

            // Show loading state
            var submitBtn = form.querySelector('[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + swData.i18n.submitting;
            }
        });
    }

    function markInvalid(field, message) {
        if (!field) return;
        field.classList.add('is-invalid');
        var feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        feedback.textContent = message;
        field.parentNode.appendChild(feedback);
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    /* ==========================================================
       Product Gallery Thumbnails
       ========================================================== */
    function initGallery() {
        var thumbnails = document.querySelectorAll('.gallery-thumb');
        var mainImage = document.getElementById('sw-main-image');
        if (!thumbnails.length || !mainImage) return;

        thumbnails.forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                var fullUrl = thumb.getAttribute('data-full');
                if (!fullUrl) return;

                mainImage.style.opacity = '0';
                setTimeout(function () {
                    mainImage.src = fullUrl;
                    mainImage.style.opacity = '1';
                }, 150);

                thumbnails.forEach(function (t) {
                    t.classList.remove('active');
                });
                thumb.classList.add('active');
            });
        });
    }

    /* ==========================================================
       Share Button (Web Share API with fallback)
       ========================================================== */
    function initShareButton() {
        var btn = document.getElementById('sw-share-btn');
        if (!btn) return;

        btn.addEventListener('click', function () {
            var shareData = {
                title: document.title,
                text: document.title,
                url: window.location.href,
            };

            if (navigator.share) {
                navigator.share(shareData).catch(function () {});
            } else {
                // Fallback: copy URL to clipboard
                navigator.clipboard.writeText(window.location.href).then(function () {
                    showToast('Link copied to clipboard!');
                }).catch(function () {
                    // Final fallback
                    prompt('Copy this link:', window.location.href);
                });
            }
        });
    }

    /* ==========================================================
       Toast Notification
       ========================================================== */
    function showToast(message) {
        var toastEl = document.getElementById('swSuccessToast');
        if (!toastEl) return;

        if (message) {
            var body = toastEl.querySelector('.toast-body');
            if (body) {
                body.innerHTML = '<i class="bi bi-check-circle me-2"></i>' + message;
            }
        }

        var toast = bootstrap.Toast.getOrCreateInstance(toastEl);
        toast.show();
    }

    /* ==========================================================
       Check URL for inquiry success param and show toast
       ========================================================== */
    function checkInquiryResult() {
        var params = new URLSearchParams(window.location.search);
        if (params.get('inquiry') === 'success') {
            setTimeout(function () {
                showToast();
            }, 300);
        }
    }

    /* ==========================================================
       Navbar Scroll Effect
       ========================================================== */
    function initNavbarScroll() {
        var header = document.querySelector('.site-header');
        if (!header) return;

        var scrollThreshold = 50;

        window.addEventListener('scroll', function () {
            if (window.scrollY > scrollThreshold) {
                header.classList.add('shadow');
            } else {
                header.classList.remove('shadow');
            }
        }, { passive: true });
    }

    /* ==========================================================
       Smooth Scroll for Anchor Links
       ========================================================== */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                var targetId = this.getAttribute('href');
                if (targetId === '#') return;

                var target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    var headerHeight = document.querySelector('.site-header');
                    var offset = headerHeight ? headerHeight.offsetHeight : 0;
                    var top = target.getBoundingClientRect().top + window.pageYOffset - offset - 10;

                    window.scrollTo({
                        top: top,
                        behavior: 'smooth',
                    });
                }
            });
        });
    }

    /* ==========================================================
       Lazy Load Images (simple IntersectionObserver fallback)
       ========================================================== */
    function initLazyLoad() {
        if ('loading' in HTMLImageElement.prototype) return; // native support

        var images = document.querySelectorAll('img[loading="lazy"]');
        if (!images.length) return;

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                        }
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(function (img) {
                observer.observe(img);
            });
        }
    }

    /* ==========================================================
       Initialize Everything on DOMContentLoaded
       ========================================================== */
    document.addEventListener('DOMContentLoaded', function () {
        initInquiryButtons();
        initInquiryCart();
        initInquiryForm();
        initGallery();
        initShareButton();
        checkInquiryResult();
        initNavbarScroll();
        initSmoothScroll();
        initLazyLoad();
    });

})();
