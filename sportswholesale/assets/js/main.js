/**
 * Sports Wholesale Theme - Main JavaScript
 *
 * Handles: inquiry modal, gallery switching, form validation,
 * share button, toast notifications.
 *
 * @package SportsWholesale
 */

(function () {
    'use strict';

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
        initInquiryForm();
        initGallery();
        initShareButton();
        checkInquiryResult();
        initNavbarScroll();
        initSmoothScroll();
        initLazyLoad();
    });

})();
