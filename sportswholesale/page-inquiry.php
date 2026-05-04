<?php
/**
 * Inquiry page template (standalone page, optional)
 *
 * @package SportsWholesale
 */

get_header();

$inquiry_status = isset( $_GET['inquiry'] ) ? sanitize_text_field( wp_unslash( $_GET['inquiry'] ) ) : '';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h1 class="h3"><?php esc_html_e( 'Contact Us for a Wholesale Quote', 'sportswholesale' ); ?></h1>
                <p class="text-muted"><?php esc_html_e( 'Fill out the form below and our sales team will get back to you within 24 hours.', 'sportswholesale' ); ?></p>
            </div>

            <?php if ( 'success' === $inquiry_status ) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?php esc_html_e( 'Your inquiry has been sent successfully! We will contact you soon.', 'sportswholesale' ); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php esc_attr_e( 'Close', 'sportswholesale' ); ?>"></button>
                </div>
            <?php elseif ( 'error' === $inquiry_status ) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?php esc_html_e( 'Please fill in all required fields.', 'sportswholesale' ); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php esc_attr_e( 'Close', 'sportswholesale' ); ?>"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <?php
                    $countries = sportswholesale_get_countries();
                    $prefilled_product = isset( $_GET['product'] ) ? sanitize_text_field( wp_unslash( $_GET['product'] ) ) : '';
                    ?>
                    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
                        <?php wp_nonce_field( 'sw_inquiry_form', 'sw_inquiry_nonce' ); ?>
                        <input type="hidden" name="action" value="sw_inquiry">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="page_sw_name" class="form-label"><?php esc_html_e( 'Full Name', 'sportswholesale' ); ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="page_sw_name" name="sw_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="page_sw_email" class="form-label"><?php esc_html_e( 'Email Address', 'sportswholesale' ); ?> <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="page_sw_email" name="sw_email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="page_sw_phone" class="form-label"><?php esc_html_e( 'Phone / WhatsApp', 'sportswholesale' ); ?></label>
                                <input type="text" class="form-control" id="page_sw_phone" name="sw_phone">
                            </div>
                            <div class="col-md-6">
                                <label for="page_sw_country" class="form-label"><?php esc_html_e( 'Country', 'sportswholesale' ); ?></label>
                                <select class="form-select" id="page_sw_country" name="sw_country">
                                    <?php foreach ( $countries as $code => $label ) : ?>
                                        <option value="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( $label ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="page_sw_product" class="form-label"><?php esc_html_e( 'Interested Product', 'sportswholesale' ); ?></label>
                                <input type="text" class="form-control" id="page_sw_product" name="sw_product" value="<?php echo esc_attr( $prefilled_product ); ?>">
                            </div>
                            <div class="col-12">
                                <label for="page_sw_message" class="form-label"><?php esc_html_e( 'Message', 'sportswholesale' ); ?></label>
                                <textarea class="form-control" id="page_sw_message" name="sw_message" rows="5" placeholder="<?php esc_attr_e( 'Tell us about your requirements, quantity, customization needs, etc.', 'sportswholesale' ); ?>"></textarea>
                            </div>
                            <!-- Honeypot -->
                            <div class="d-none" aria-hidden="true">
                                <input type="text" name="sw_company_url" tabindex="-1" autocomplete="off">
                            </div>
                            <div class="col-12">
                                <button type="submit" name="sw_inquiry_submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-send me-2"></i><?php esc_html_e( 'Send Inquiry', 'sportswholesale' ); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
