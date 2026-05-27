<?php
/**
 * Template part: Inquiry form
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

$countries = sportswholesale_get_countries();
?>

<!-- Inquiry Cart Floating Button -->
<div id="sw-inquiry-cart-btn" class="position-fixed bottom-0 start-0 p-3 d-none" style="z-index:1070">
    <button type="button" class="btn btn-primary btn-lg rounded-circle shadow position-relative" 
            id="sw-open-cart" title="<?php esc_attr_e( 'View Inquiry Cart', 'sportswholesale' ); ?>">
        <i class="bi bi-cart3"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="sw-cart-count">0</span>
    </button>
</div>

<!-- Inquiry Cart Modal -->
<div class="modal fade" id="inquiryCartModal" tabindex="-1" aria-labelledby="inquiryCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="inquiryCartModalLabel">
                    <i class="bi bi-cart3 me-2"></i><?php esc_html_e( 'Inquiry Cart', 'sportswholesale' ); ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'sportswholesale' ); ?>"></button>
            </div>
            <div class="modal-body">
                <div id="sw-cart-empty" class="text-center py-4">
                    <i class="bi bi-cart-x text-muted" style="font-size:3rem;"></i>
                    <p class="mt-3 text-muted"><?php esc_html_e( 'Your inquiry cart is empty', 'sportswholesale' ); ?></p>
                    <p class="text-muted small"><?php esc_html_e( 'Click the cart icon on products to add them', 'sportswholesale' ); ?></p>
                </div>
                <div id="sw-cart-items" class="d-none">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?php esc_html_e( 'Product', 'sportswholesale' ); ?></th>
                                    <th><?php esc_html_e( 'Category', 'sportswholesale' ); ?></th>
                                    <th class="text-center"><?php esc_html_e( 'Qty', 'sportswholesale' ); ?></th>
                                    <th class="text-end"><?php esc_html_e( 'Action', 'sportswholesale' ); ?></th>
                                </tr>
                            </thead>
                            <tbody id="sw-cart-table-body">
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-outline-danger btn-sm" id="sw-clear-cart">
                            <i class="bi bi-trash me-1"></i><?php esc_html_e( 'Clear All', 'sportswholesale' ); ?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e( 'Continue Browsing', 'sportswholesale' ); ?></button>
                <button type="button" class="btn btn-primary" id="sw-submit-cart-inquiry" disabled>
                    <i class="bi bi-send me-1"></i><?php esc_html_e( 'Submit Inquiry', 'sportswholesale' ); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Inquiry Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="inquiryModalLabel">
                    <i class="bi bi-envelope me-2"></i><?php esc_html_e( 'Request a Quote', 'sportswholesale' ); ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'sportswholesale' ); ?>"></button>
            </div>
            <form id="sw-inquiry-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
                <?php wp_nonce_field( 'sw_inquiry_form', 'sw_inquiry_nonce' ); ?>
                <input type="hidden" name="action" value="sw_inquiry">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="sw_name" class="form-label"><?php esc_html_e( 'Full Name', 'sportswholesale' ); ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sw_name" name="sw_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sw_email" class="form-label"><?php esc_html_e( 'Email Address', 'sportswholesale' ); ?> <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="sw_email" name="sw_email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sw_phone" class="form-label"><?php esc_html_e( 'Phone / WhatsApp', 'sportswholesale' ); ?></label>
                            <input type="text" class="form-control" id="sw_phone" name="sw_phone">
                        </div>
                        <div class="col-md-6">
                            <label for="sw_country" class="form-label"><?php esc_html_e( 'Country', 'sportswholesale' ); ?></label>
                            <select class="form-select" id="sw_country" name="sw_country">
                                <?php foreach ( $countries as $code => $label ) : ?>
                                    <option value="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( $label ); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="sw_product" class="form-label"><?php esc_html_e( 'Interested Products', 'sportswholesale' ); ?></label>
                            <input type="hidden" name="sw_products" id="sw_products" value="">
                            <div id="sw-selected-products" class="mb-2"></div>
                            <input type="text" class="form-control" id="sw_product" name="sw_product" 
                                   placeholder="<?php esc_attr_e( 'Enter product name or select from cart', 'sportswholesale' ); ?>">
                        </div>
                        <div class="col-12">
                            <label for="sw_message" class="form-label"><?php esc_html_e( 'Message', 'sportswholesale' ); ?></label>
                            <textarea class="form-control" id="sw_message" name="sw_message" rows="4" placeholder="<?php esc_attr_e( 'Tell us about your requirements, quantity, customization needs, etc.', 'sportswholesale' ); ?>"></textarea>
                        </div>
                        <!-- Honeypot field - hidden from users, bots will fill it -->
                        <div class="d-none" aria-hidden="true">
                            <input type="text" name="sw_company_url" tabindex="-1" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e( 'Cancel', 'sportswholesale' ); ?></button>
                    <button type="submit" name="sw_inquiry_submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i><?php esc_html_e( 'Send Inquiry', 'sportswholesale' ); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:1080">
    <div id="swSuccessToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle me-2"></i><?php esc_html_e( 'Your inquiry has been sent successfully! We will contact you soon.', 'sportswholesale' ); ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="<?php esc_attr_e( 'Close', 'sportswholesale' ); ?>"></button>
        </div>
    </div>
</div>
