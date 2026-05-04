<?php
/**
 * Template part: Inquiry form
 *
 * @package SportsWholesale
 */

defined( 'ABSPATH' ) || exit;

$countries = sportswholesale_get_countries();
?>

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
                            <label for="sw_product" class="form-label"><?php esc_html_e( 'Interested Product', 'sportswholesale' ); ?></label>
                            <input type="text" class="form-control" id="sw_product" name="sw_product">
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
